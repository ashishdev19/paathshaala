<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * WalletService
 * 
 * Central service for all wallet operations with transaction safety.
 * All balance changes are atomic and create audit trail in wallet_transactions.
 */
class WalletService
{
    /**
     * Credit amount to wallet
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function credit(Wallet $wallet, $amount, $description = 'Wallet credited', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Credit amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            // Lock wallet for update to prevent race conditions
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            $balanceBefore = $wallet->balance;
            $wallet->balance += $amount;
            $wallet->save();

            // Create transaction record
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_CREDIT,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('CR'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Debit amount from wallet
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function debit(Wallet $wallet, $amount, $description = 'Wallet debited', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Debit amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            // Lock wallet for update
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            // Check sufficient balance
            if (!$wallet->hasSufficientBalance($amount)) {
                throw new \Exception('Insufficient wallet balance');
            }

            $balanceBefore = $wallet->balance;
            $wallet->balance -= $amount;
            $wallet->save();

            // Create transaction record
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_DEBIT,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('DB'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Hold amount in wallet (move to reserved_amount)
     * Used when payment is pending completion/verification
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function hold(Wallet $wallet, $amount, $description = 'Amount held', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Hold amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            if (!$wallet->hasSufficientBalance($amount)) {
                throw new \Exception('Insufficient wallet balance for hold');
            }

            $balanceBefore = $wallet->balance;
            $wallet->reserved_amount += $amount;
            $wallet->save();

            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_HOLD,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('HLD'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Release held amount and move to available balance
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function release(Wallet $wallet, $amount, $description = 'Amount released', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Release amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            if ($wallet->reserved_amount < $amount) {
                throw new \Exception('Insufficient reserved amount for release');
            }

            $balanceBefore = $wallet->balance;
            $wallet->reserved_amount -= $amount;
            $wallet->save();

            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_RELEASE,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('RLS'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Process payout (deduct from balance for withdrawal)
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function payout(Wallet $wallet, $amount, $description = 'Withdrawal payout', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Payout amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            if (!$wallet->hasSufficientBalance($amount)) {
                throw new \Exception('Insufficient wallet balance for payout');
            }

            $balanceBefore = $wallet->balance;
            $wallet->balance -= $amount;
            $wallet->save();

            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_PAYOUT,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('PO'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Process refund (credit back to wallet)
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function refund(Wallet $wallet, $amount, $description = 'Refund credited', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Refund amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            $balanceBefore = $wallet->balance;
            $wallet->balance += $amount;
            $wallet->save();

            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_REFUND,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('RF'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Deduct platform commission
     * 
     * @param Wallet $wallet
     * @param float $amount
     * @param string $description
     * @param array $meta
     * @param int|null $createdBy
     * @return WalletTransaction
     * @throws \Exception
     */
    public function commission(Wallet $wallet, $amount, $description = 'Platform commission', $meta = [], $createdBy = null)
    {
        if ($amount <= 0) {
            throw new \Exception('Commission amount must be greater than zero');
        }

        return DB::transaction(function () use ($wallet, $amount, $description, $meta, $createdBy) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            
            if ($wallet->balance < $amount) {
                throw new \Exception('Insufficient balance for commission deduction');
            }

            $balanceBefore = $wallet->balance;
            $wallet->balance -= $amount;
            $wallet->save();

            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => WalletTransaction::TYPE_COMMISSION,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $wallet->balance,
                'reference' => $this->generateReference('COM'),
                'description' => $description,
                'meta' => $meta,
                'created_by' => $createdBy,
            ]);

            return $transaction;
        });
    }

    /**
     * Generate unique transaction reference
     * 
     * @param string $prefix
     * @return string
     */
    private function generateReference($prefix = 'TXN')
    {
        return $prefix . '-' . strtoupper(Str::random(10)) . '-' . time();
    }

    /**
     * Get wallet balance summary
     * 
     * @param Wallet $wallet
     * @return array
     */
    public function getBalanceSummary(Wallet $wallet)
    {
        return [
            'total_balance' => $wallet->balance,
            'reserved_amount' => $wallet->reserved_amount,
            'available_balance' => $wallet->available_balance,
            'currency' => $wallet->currency,
        ];
    }
}

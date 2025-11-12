<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of notifications
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Notification::where('user_id', $user->id);

        // Apply filters
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(15);

        $unreadCount = NotificationService::getUnreadCount($user->id);

        $stats = [
            'total' => Notification::where('user_id', $user->id)->count(),
            'unread' => $unreadCount,
            'read' => Notification::where('user_id', $user->id)->where('is_read', true)->count(),
            'today' => Notification::where('user_id', $user->id)
                                 ->whereDate('created_at', today())
                                 ->count(),
        ];

        return view('notifications.index', compact('notifications', 'unreadCount', 'stats'));
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Request $request, Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'unread_count' => NotificationService::getUnreadCount(Auth::id())
            ]);
        }

        return back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark a notification as unread
     */
    public function markAsUnread(Request $request, Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsUnread();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as unread',
                'unread_count' => NotificationService::getUnreadCount(Auth::id())
            ]);
        }

        return back()->with('success', 'Notification marked as unread');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $count = NotificationService::markAllAsRead(Auth::id());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$count} notifications marked as read",
                'unread_count' => 0
            ]);
        }

        return back()->with('success', "{$count} notifications marked as read");
    }

    /**
     * Delete a notification
     */
    public function destroy(Request $request, Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted',
                'unread_count' => NotificationService::getUnreadCount(Auth::id())
            ]);
        }

        return back()->with('success', 'Notification deleted');
    }

    /**
     * Get notifications for dropdown/modal
     */
    public function getRecent(Request $request)
    {
        $user = Auth::user();
        $notifications = NotificationService::getRecent($user->id, 10);
        $unreadCount = NotificationService::getUnreadCount($user->id);

        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'time_ago' => $notification->time_ago,
                    'is_read' => $notification->is_read,
                    'icon_class' => $notification->icon_class,
                    'priority_color' => $notification->priority_color,
                    'action_url' => $notification->action_url,
                    'created_at' => $notification->created_at->toISOString(),
                ];
            }),
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Show a specific notification
     */
    public function show(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read when viewed
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        // If there's an action URL, redirect to it
        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Get notification counts by type
     */
    public function getStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => Notification::where('user_id', $user->id)->count(),
            'unread' => NotificationService::getUnreadCount($user->id),
            'by_type' => Notification::where('user_id', $user->id)
                                   ->selectRaw('type, COUNT(*) as count')
                                   ->groupBy('type')
                                   ->pluck('count', 'type'),
            'by_priority' => Notification::where('user_id', $user->id)
                                       ->selectRaw('priority, COUNT(*) as count')
                                       ->groupBy('priority')
                                       ->pluck('count', 'priority'),
        ];

        return response()->json($stats);
    }
}

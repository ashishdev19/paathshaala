<style>
    .dashboard-footer {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-top: 2px solid transparent;
        border-image: linear-gradient(90deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0), rgba(148, 163, 184, 0.3)) 1;
        padding: 3rem 2rem 2rem;
        margin-top: 3.5rem;
        font-size: 0.875rem;
        color: #64748b;
        position: relative;
        overflow: hidden;
    }

    .dashboard-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #cbd5e1, transparent);
    }

    .footer-wrapper {
        max-width: 1400px;
        margin: 0 auto;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(3, minmax(240px, 1fr));
        gap: 2rem;
        margin-bottom: 2.25rem;
    }

    .footer-section {
        animation: fadeInUp 0.6s ease-out;
    }

    .footer-section h4 {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .footer-section h4::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 2rem;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6, transparent);
        border-radius: 1px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .footer-section li {
        margin-bottom: 0;
    }

    .footer-section a {
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        padding-left: 0;
    }

    .footer-section a::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        transition: width 0.3s ease;
    }

    .footer-section a:hover {
        color: #3b82f6;
        padding-left: 6px;
    }

    .footer-section a:hover::before {
        width: 100%;
    }

    .footer-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #cbd5e1, transparent);
        margin: 1.5rem 0;
    }

    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
    }

    .footer-left {
        flex: 1;
        min-width: 200px;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .footer-copyright {
        color: #78909c;
        font-size: 0.8rem;
        line-height: 1.5;
    }

    .footer-copyright p {
        margin: 0;
    }

    .footer-right {
        display: flex;
        align-items: center;
        gap: 3rem;
        flex-wrap: wrap;
    }

    .footer-links {
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .footer-links a {
        color: #64748b;
        font-size: 0.8rem;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-links a:hover {
        color: #3b82f6;
    }

    .footer-social {
        display: flex;
        gap: 0.75rem;
    }

    .footer-social a {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: white;
        border: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.95rem;
        position: relative;
        overflow: hidden;
    }

    .footer-social a::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.4s ease;
        z-index: -1;
    }

    .footer-social a:hover {
        border-color: #3b82f6;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(59, 130, 246, 0.25);
    }

    .footer-social a:hover::before {
        transform: translate(-50%, -50%) scale(1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .dashboard-footer {
            padding: 3rem 1.5rem 1.5rem;
            margin-top: 3rem;
        }

        .footer-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 2rem;
            text-align: center;
        }

        .footer-right {
            flex-direction: column;
            width: 100%;
            gap: 1.5rem;
        }

        .footer-links {
            flex-direction: column;
            gap: 1rem;
        }

        .footer-social {
            justify-content: center;
        }

        .footer-left {
            text-align: center;
        }
    }
</style>

<footer class="dashboard-footer">
    <div class="footer-wrapper">
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section">
                <h4>About PaathShaala</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Mission</a></li>
                    <li><a href="#">Careers</a></li>
                    
                </ul>
            </div>

            <!-- Support Section -->
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Report Issue</a></li>
                </ul>
            </div>

            <!-- Legal Section -->
            <div class="footer-section">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">Security</a></li>
                </ul>
            </div>

            <!-- Resources section removed per request -->
        </div>

        <!-- Divider -->
        <div class="footer-divider"></div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
                <div class="footer-left">
                    <div class="footer-social">
                        <a href="#" title="Facebook" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" title="Twitter" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" title="LinkedIn" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" title="Instagram" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>

                    <div class="footer-copyright">
                        <p>
                            &copy; {{ date('Y') }} PaathShaala. All rights reserved.
                            <br>
                            Made with <span style="color: #ef4444;">❤️</span> for education
                        </p>
                    </div>
                </div>

                <div class="footer-right">
                    <!-- Intentionally left empty - social icons moved to the left -->
                </div>
        </div>
    </div>
</footer>

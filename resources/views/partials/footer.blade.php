<footer class="bg-onyx text-silver pt-5 pb-4" role="contentinfo" aria-label="Site Footer" style="border-top: 1px solid rgba(241, 229, 172, 0.05); position: relative; z-index: 10;">
    <div class="container">
        <div class="row g-5">
            <!-- Brand & Philosophy -->
            <div class="col-md-6 col-lg-5">
                <div class="mb-4">
                    <a class="navbar-brand d-flex align-items-center mb-3" href="{{ url('/') }}" style="font-size: 1.6rem; font-weight: 800; letter-spacing: -0.5px;">
                        <i class="fas fa-crown text-accent me-2 fs-5"></i>
                        <span class="gradient-text">TryMyWatch</span>
                    </a>
                    <p class="text-silver-dim" style="max-width: 380px; line-height: 1.8; font-size: 0.95rem;">
                        Transcending traditional horology through the lens of innovation. Our AI-driven sanctuary allows you to experience the world's finest timepieces with unprecedented digital precision.
                    </p>
                </div>
                <div class="social-links d-flex gap-3">
                    <a href="#" class="social-link-luxury" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link-luxury" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link-luxury" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link-luxury" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Contact & Atelier -->
            <div class="col-md-6 col-lg-4">
                <h6 class="text-accent text-uppercase fw-bold mb-4" style="letter-spacing: 2px; font-size: 0.8rem;">The Atelier</h6>
                <ul class="list-unstyled text-silver-dim" style="line-height: 2;">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="fas fa-location-dot mt-1 me-3 text-accent opacity-50"></i>
                        <span>University of Management and Technology,<br>Knowledge Park, Lahore</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="fas fa-envelope me-3 text-accent opacity-50"></i>
                        <a href="mailto:concierge@trymywatch.com" class="text-silver-dim text-decoration-none hover-accent">concierge@trymywatch.com</a>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fas fa-phone-volume me-3 text-accent opacity-50"></i>
                        <a href="tel:+15551234567" class="text-silver-dim text-decoration-none hover-accent">+1 (555) LUX-WATCH</a>
                    </li>
                </ul>
            </div>

            <!-- Navigation -->
            <div class="col-md-12 col-lg-3">
                <h6 class="text-accent text-uppercase fw-bold mb-4" style="letter-spacing: 2px; font-size: 0.8rem;">Discover</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ url('/') }}" class="footer-link">Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/shop') }}" class="footer-link">Shop</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/about') }}" class="footer-link">About Us</a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="footer-link">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-5 pt-4 border-top border-silver-dim d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="small text-silver-dim" style="letter-spacing: 0.5px;">
                &copy; {{ date('Y') }} TryMyWatch. Engineered for Excellence.
            </div>
            <div class="d-flex gap-4 small">
                <a href="#" class="text-silver-dim text-decoration-none hover-accent">Privacy Policy</a>
                <a href="#" class="text-silver-dim text-decoration-none hover-accent">Terms of Service</a>
            </div>
        </div>
    </div>

    <style>
        .text-silver-dim { color: rgba(197, 198, 199, 0.6); }
        .border-silver-dim { border-color: rgba(197, 198, 199, 0.05) !important; }
        
        .social-link-luxury {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(197, 198, 199, 0.05);
            border: 1px solid rgba(197, 198, 199, 0.1);
            border-radius: 50%;
            color: var(--accent);
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .social-link-luxury:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-5px) rotate(8deg);
            box-shadow: 0 5px 15px rgba(241, 229, 172, 0.3);
        }
        
        .footer-link {
            color: rgba(197, 198, 199, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 0.95rem;
        }
        
        .footer-link:hover {
            color: var(--accent);
            transform: translateX(10px);
        }
        
        .hover-accent:hover {
            color: var(--accent) !important;
        }

        @media (max-width: 768px) {
            .footer-link:hover {
                transform: translateX(5px);
            }
        }
    </style>
</footer>

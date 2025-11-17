<footer class="bg-secondary-custom text-light pt-5 pb-4" role="contentinfo" aria-label="Site Footer" style="border-top: 1px solid #2a2a2a; margin-top: 80px;">
    <div class="container">
        <div class="row g-4">
            <!-- Brand & About -->
            <div class="col-md-6 col-lg-4">
<h5 class="mb-3 fw-semibold border-bottom border-secondary pb-2" style="letter-spacing: 1.5px;">TryMyWatch</h5>
                <p class="text-secondary-custom" style="max-width: 320px; line-height: 1.6;">
                    Revolutionizing online watch shopping with advanced AI and Augmented Reality technology.
                </p>
                <div class="social-links mt-4">
                    <a href="#" class="text-accent me-3 fs-5" aria-label="Facebook" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-accent me-3 fs-5" aria-label="Twitter" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-accent me-3 fs-5" aria-label="Instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-accent fs-5" aria-label="LinkedIn" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-md-6 col-lg-4">
                <h5 class="mb-3 fw-semibold border-bottom border-secondary pb-2">Contact Info</h5>
                <ul class="list-unstyled text-secondary-custom" style="line-height: 1.8;">
                    <li>
                        <i class="fas fa-map-marker-alt me-2 text-accent"></i>
                        University of Management and Technology
                    </li>
                    <li>
                        <i class="fas fa-envelope me-2 text-accent"></i>
                        <a href="mailto:contact@trymywatch.com" class="text-secondary-custom text-decoration-none">contact@trymywatch.com</a>
                    </li>
                    <li>
                        <i class="fas fa-phone me-2 text-accent"></i>
                        <a href="tel:+15551234567" class="text-secondary-custom text-decoration-none">+1 (555) 123-4567</a>
                    </li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="col-md-12 col-lg-4">
                <h5 class="mb-3 fw-semibold border-bottom border-secondary pb-2">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ url('/') }}" class="text-secondary-custom text-decoration-none">Home</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/shop') }}" class="text-secondary-custom text-decoration-none">Shop</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/about') }}" class="text-secondary-custom text-decoration-none">About Us</a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="text-secondary-custom text-decoration-none">Contact</a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="text-center small text-secondary-custom" style="letter-spacing: 0.04em;">
            &copy; {{ date('Y') }} TryMyWatch &mdash; AI-Powered AR Watch Try-On Platform. All rights reserved.
        </div>
    </div>

    <style>
        footer a.text-secondary-custom:hover {
            color: var(--accent);
            text-decoration: underline;
            transition: color 0.3s ease;
        }
        footer .social-links a:hover {
            color: var(--accent-light);
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }
    </style>
</footer>

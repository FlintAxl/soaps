<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Soap Haven!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f5ff;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #9370db, #d8bfd8);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .email-logo {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .email-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 1rem 0 0;
        }

        .email-divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #e6e6fa, white, #e6e6fa);
            margin: 1.5rem auto;
        }

        .email-content {
            padding: 2rem;
            line-height: 1.6;
        }

        .welcome-message {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: #555;
        }

        .user-name {
            color: #9370db;
            font-weight: 600;
        }

        .cta-button {
            display: inline-block;
            background-color: #9370db;
            color: white !important;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            margin: 1.5rem 0;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            background-color: #7b5dbf;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.3);
        }

        .email-footer {
            background-color: #f8f5ff;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .social-icons {
            margin: 1rem 0;
        }

        .social-icon {
            display: inline-block;
            margin: 0 0.5rem;
            color: #9370db;
            font-size: 1.2rem;
        }

        .product-showcase {
            margin: 2rem 0;
            border: 1px solid #e6e6fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f8f5ff;
        }

        .product-info {
            padding: 1rem;
            text-align: center;
        }

        .product-name {
            color: #9370db;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="email-logo">SOAP HAVEN</div>
            <div class="email-divider"></div>
            <h1 class="email-title">Welcome Aboard!</h1>
        </div>

        <div class="email-content">
            <p class="welcome-message">
                Hello <span class="user-name">{{ $user->name }}</span>,<br><br>
                Thank you for joining the Soap Haven family! We're thrilled to have you with us.
            </p>


            <div class="product-showcase">
                <div class="product-image" style="background-color: #f8f5ff;">
                    <!-- Replace with actual product image -->
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%; color: #9370db; font-size: 1.2rem;">
                        Our Premium Soap Collection
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-name">Discover Your New Favorite Soap</div>
                    <p style="font-size: 0.9rem; color: #6c757d;">Handcrafted with natural ingredients for your skin's delight</p>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/products') }}" class="cta-button">Start Shopping Now</a>
            </div>


        </div>


            <p>
                © {{ date('Y') }} Soap Haven. All rights reserved.<br>
                <a href="#" style="color: #9370db;">Unsubscribe</a> | <a href="#" style="color: #9370db;">Privacy Policy</a>
            </p>
        </div>
    </div>
</body>
</html>

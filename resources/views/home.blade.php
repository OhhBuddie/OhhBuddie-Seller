<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Layout</title>
    <style>
        /* Hide desktop layout on small screens */
        @media screen and (max-width: 768px) {
            .desktop-layout {
                display: none;
            }
            .mobile-layout {
                display: block;
            }
        }

        /* Hide mobile layout on large screens */
        @media screen and (min-width: 769px) {
            .desktop-layout {
                display: block;
            }
            .mobile-layout {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Desktop Layout -->
    <div class="desktop-layout">
        @include('desktop')
    </div>

    <!-- Mobile Layout -->
    <div class="mobile-layout">
        @include('mobile')
    </div>
</body>
</html>

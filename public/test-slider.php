<?php
require_once '../vendor/autoload.php';
require_once '../app/Helpers/helpers.php';

// Create a database connection
$db = new PDO('mysql:host=localhost;dbname='.env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));

// Get offer images
$stmt = $db->query("SELECT * FROM offer_images WHERE status = 1 ORDER BY `order` ASC");
$offerImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Slider</title>
    
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    
    <style>
        .offer-slider-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .offer-slide {
            position: relative;
            overflow: hidden;
            height: 150px;
        }
        
        .offer-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .debug-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 800px; margin: 50px auto; padding: 20px;">
        <h1>Test Slider</h1>
        
        <div class="offer-slider-container">
            <div class="offer-slider">
                <?php foreach ($offerImages as $offerImage): ?>
                    <div class="offer-slide">
                        <?php 
                        $imageUrl = getFile($offerImage['image_driver'], $offerImage['image'], true);
                        if (!empty($offerImage['url'])): 
                        ?>
                            <a href="<?= $offerImage['url'] ?>" target="_blank">
                                <img src="<?= $imageUrl ?>" alt="<?= $offerImage['title'] ?>">
                            </a>
                        <?php else: ?>
                            <img src="<?= $imageUrl ?>" alt="<?= $offerImage['title'] ?>">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                
                <?php if (count($offerImages) === 0): ?>
                    <div class="offer-slide">
                        <p style="text-align: center; padding: 50px 0;">No offer images available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="debug-info">
            <h3>Debug Information</h3>
            <p>Number of offer images: <?= count($offerImages) ?></p>
            
            <?php if (count($offerImages) > 0): ?>
                <h4>Image Details:</h4>
                <ul>
                    <?php foreach ($offerImages as $offerImage): ?>
                        <li>
                            <strong>Title:</strong> <?= $offerImage['title'] ?><br>
                            <strong>Image Path:</strong> <?= $offerImage['image'] ?><br>
                            <strong>Image Driver:</strong> <?= $offerImage['image_driver'] ?><br>
                            <strong>Image URL:</strong> <?= getFile($offerImage['image_driver'], $offerImage['image'], true) ?><br>
                            <strong>Link URL:</strong> <?= $offerImage['url'] ?? 'N/A' ?><br>
                            <strong>Status:</strong> <?= $offerImage['status'] ? 'Active' : 'Inactive' ?><br>
                            <img src="<?= getFile($offerImage['image_driver'], $offerImage['image'], true) ?>" alt="<?= $offerImage['title'] ?>" style="max-width: 200px; max-height: 100px;">
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Slick Slider JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    
    <script>
        $(document).ready(function(){
            console.log('Document ready');
            console.log('Offer images count:', $('.offer-slider .offer-slide').length);
            
            try {
                $('.offer-slider').slick({
                    dots: true,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    fade: true,
                    cssEase: 'linear'
                });
                console.log('Slider initialized');
            } catch (e) {
                console.error('Error initializing slider:', e);
            }
        });
    </script>
</body>
</html> 
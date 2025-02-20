<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-left">
        <h1 class="site-title">E-Commerce Dashboard  <a href="home.php" class="home-link">Home</a></h1>

        </div>
        <div class="navbar-right">
            <button class="account"><a href="account.php" class="account-link">Account</a></button>
        </div>
    </div>

    <!-- Products Section -->
    <div class="products-container">
        <div id="product-grid" class="product-grid">
            <!-- Products will be dynamically added here -->
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2024 E-Commerce Dashboard. All rights reserved.</p>
    </div>

    <script>
        // Fetch and display products
        const displayProducts = async () => {
            const response = await fetch('products.xml');
            const xmlData = await response.text();
            const parser = new DOMParser();
            const xml = parser.parseFromString(xmlData, 'application/xml');
            const products = xml.getElementsByTagName('product');
            const productGrid = document.getElementById('product-grid');

            Array.from(products).forEach(product => {
                const id = product.getElementsByTagName('id')[0].textContent;
                const name = product.getElementsByTagName('name')[0].textContent;
                const price = product.getElementsByTagName('price')[0].textContent;
                const description = product.getElementsByTagName('description')[0].textContent;
                const image = product.getElementsByTagName('image')[0].textContent;

                // Create product box
                const productBox = document.createElement('div');
                productBox.className = 'product-box';

                productBox.innerHTML = `
                    <img src="${image}" alt="${name}" class="product-image">
                    <h3 class="product-name">${name}</h3>
                    <p class="product-description">${description}</p>
                    <p class="product-price">₹${price}</p>
                `;

                productGrid.appendChild(productBox);
            });
        };

        displayProducts();
    </script>
</body>
</html>

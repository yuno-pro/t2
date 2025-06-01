const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    });
}
const productDivs = document.querySelectorAll(".pro");

for(let proDiv of productDivs){
    proDiv.addEventListener("click", (event) => {
        console.log("Product div clicked");
        // Prevent click if the target is the cart icon or inside it
        if(event.target.closest('a') && event.target.closest('a').querySelector('i') && event.target.closest('a').querySelector('i').classList.contains('cart')){
            console.log("Click on cart icon inside product div, ignoring product div click");
            return; // Do nothing, let cart icon click handler handle it
        }
        const imgSrc = proDiv.querySelector('img').src;
        const productName = proDiv.querySelector('.des h5').innerText;
        const productPrice = proDiv.querySelector('.des h4').innerText;
        // Encode data to pass via URL
        const basePath = window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1);
        const url = new URL('sproduct.html', window.location.origin + basePath);
        url.searchParams.set('image', imgSrc);
        url.searchParams.set('name', productName);
        // Strip currency symbol and whitespace from price before sending
        const numericPrice = productPrice.replace(/[^\d.]/g, '');
        url.searchParams.set('price', numericPrice);
        console.log("Redirecting to product page:", url.toString());
        window.location.href = url.toString();
    });
}

// Add click event listeners to cart icon anchors to handle add to cart
const cartIcons = document.querySelectorAll('.pro a');
for(let cartIcon of cartIcons){
    cartIcon.addEventListener('click', (event) => {
        if(!cartIcon.querySelector('i') || !cartIcon.querySelector('i').classList.contains('cart')){
            return; // Not a cart icon anchor, ignore
        }
        event.preventDefault();
        console.log("Cart icon clicked");
        const proDiv = cartIcon.closest('.pro');
        if(!proDiv) return;
        const imgSrc = proDiv.querySelector('img').src;
        const productName = proDiv.querySelector('.des h5').innerText;
        const productPrice = proDiv.querySelector('.des h4').innerText;
        const numericPrice = productPrice.replace(/[^\d.]/g, '');

        // Create a form and submit via POST to add_to_cart.php
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'add_to_cart.php';

        const inputName = document.createElement('input');
        inputName.type = 'hidden';
        inputName.name = 'name';
        inputName.value = productName;
        form.appendChild(inputName);

        const inputPrice = document.createElement('input');
        inputPrice.type = 'hidden';
        inputPrice.name = 'price';
        inputPrice.value = numericPrice;
        form.appendChild(inputPrice);

        const inputImage = document.createElement('input');
        inputImage.type = 'hidden';
        inputImage.name = 'image';
        inputImage.value = imgSrc;
        form.appendChild(inputImage);

        document.body.appendChild(form);
        form.submit();
    });
}

const proceedCheckoutBtn = document.getElementById('proceed-checkout-btn');

if (proceedCheckoutBtn) {
    proceedCheckoutBtn.addEventListener('click', () => {
        // Optionally, add validation here to check if cart is empty
        // For now, just redirect to checkout.php
        window.location.href = 'checkout.php';
    });
}

if (window.location.pathname.endsWith('sproduct.html')) {
    const urlParams = new URLSearchParams(window.location.search);
    const imgSrc = urlParams.get('image');
    const productName = urlParams.get('name');
    const productPrice = urlParams.get('price');

    if (imgSrc) {
        const mainImg = document.getElementById('productImage');
        if (mainImg) {
            mainImg.src = imgSrc;
        }
    }
    if (productName) {
        const productTitle = document.getElementById('productName');
        if (productTitle) {
            productTitle.textContent = productName;
        }
    }
    if (productPrice) {
        const productPriceElem = document.getElementById('productPrice');
        if (productPriceElem) {
            productPriceElem.textContent = '₱' + productPrice;
        }
    }
}

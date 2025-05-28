// This file contains the JavaScript code for the frontend application. 
// It handles user interactions, makes API calls to the PHP backend, and updates the UI based on the responses.

document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('search-form');
    const resultsContainer = document.getElementById('results');

    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const query = document.getElementById('search-input').value;
        fetchResults(query);
    });

    function fetchResults(query) {
        fetch(`http://localhost/spotify-php-api-project/api/public/index.php/search?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displayResults(data);
            })
            .catch(error => {
                console.error('Error fetching results:', error);
            });
    }

    function displayResults(data) {
        resultsContainer.innerHTML = '';
        if (data && data.length > 0) {
            data.forEach(item => {
                const resultItem = document.createElement('div');
                resultItem.className = 'result-item';
                resultItem.innerHTML = `
                    <h3>${item.name}</h3>
                    <p>${item.artist}</p>
                    <img src="${item.image}" alt="${item.name}">
                `;
                resultsContainer.appendChild(resultItem);
            });
        } else {
            resultsContainer.innerHTML = '<p>No results found.</p>';
        }
    }
});
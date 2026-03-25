document.addEventListener('DOMContentLoaded', function () {


    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    }


    const themeToggleBtn = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;

    function updateThemeIcon(theme) {
        if (!themeToggleBtn) return;
        const icon = themeToggleBtn.querySelector('i');
        if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill text-warning';
        } else {
            icon.className = 'bi bi-moon-stars-fill';
        }
    }

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);
    } else {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        htmlElement.setAttribute('data-bs-theme', prefersDark ? 'dark' : 'light');
        updateThemeIcon(prefersDark ? 'dark' : 'light');
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    }


    const homeSearchForm = document.querySelector('form[role="search"]');
    if (homeSearchForm) {
        homeSearchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const searchTerm = this.querySelector('input').value.trim();
            if (searchTerm) {
                window.location.href = `events.php?search=${encodeURIComponent(searchTerm)}`;
            }
        });


        const typingTextElement = document.getElementById('typing-text');
        if (typingTextElement) {
            const words = ['Concerts', 'Tech Meetups', 'Big Matches', 'Exhibitions', 'Cultural Festivals'];
            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;

            function typeEffect() {
                const currentWord = words[wordIndex];
                if (isDeleting) {
                    typingTextElement.innerText = currentWord.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    typingTextElement.innerText = currentWord.substring(0, charIndex + 1);
                    charIndex++;
                }

                let typeSpeed = isDeleting ? 50 : 100;

                if (!isDeleting && charIndex === currentWord.length) {
                    isDeleting = true;
                    typeSpeed = 2000;
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    wordIndex = (wordIndex + 1) % words.length;
                    typeSpeed = 500;
                }

                setTimeout(typeEffect, typeSpeed);
            }
            typeEffect();
        }


        const countdownElement = document.getElementById('countdown');
        if (countdownElement) {

            const eventDate = new Date();
            eventDate.setDate(eventDate.getDate() + 14);
            eventDate.setHours(18, 0, 0, 0);

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = eventDate.getTime() - now;

                if (distance < 0) {
                    countdownElement.innerHTML = "<h4>Event has started!</h4>";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").innerText = days.toString().padStart(2, '0');
                document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
                document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
                document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();
        }
    }


    const eventModal = document.getElementById('eventModal');
    const applyFiltersBtn = document.querySelector('.btn-primary.w-100.mt-2');
    const clearFiltersBtn = document.querySelector('.text-primary.p-0');


    if (window.location.pathname.includes('events.php')) {
        const urlParams = new URLSearchParams(window.location.search);
        const searchKeyword = urlParams.get('search');

        if (searchKeyword) {
            filterEvents(searchKeyword.toLowerCase(), 'all', []);
            const sidebarSearch = document.querySelector('.col-lg-3 input[type="text"]');
            if (sidebarSearch) sidebarSearch.value = searchKeyword;
        }
    }


    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function () {
            const searchVal = document.querySelector('.col-lg-3 input[type="text"]').value.toLowerCase();
            const selectedDistrict = document.querySelector('input[name="district"]:checked').id;
            const checkedCats = Array.from(document.querySelectorAll('.form-check-input[type="checkbox"]:checked'))
                .map(cb => cb.nextElementSibling.innerText.trim());

            filterEvents(searchVal, selectedDistrict, checkedCats);
        });
    }


    function filterEvents(searchTerm, district, categories) {
        searchTerm = searchTerm.trim().toLowerCase();
        const eventCards = document.querySelectorAll('.event-card');
        eventCards.forEach(card => {
            const title = card.querySelector('.card-title').innerText.toLowerCase();
            const districtText = card.querySelector('.text-muted').innerText.toLowerCase();
            const categoryBadge = card.querySelector('.position-absolute').innerText.trim();

            const matchesSearch = title.includes(searchTerm) || districtText.includes(searchTerm) || searchTerm === "";
            const matchesDistrict = (district === 'all') || districtText.includes(district);
            const matchesCategory = (categories.length === 0) || categories.includes(categoryBadge);

            card.style.display = (matchesSearch && matchesDistrict && matchesCategory) ? "block" : "none";
        });
    }


    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function () {
            document.querySelector('.col-lg-3 input[type="text"]').value = '';
            document.getElementById('all').checked = true;
            document.querySelectorAll('.form-check-input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.querySelectorAll('.event-card').forEach(card => card.style.display = "block");
        });
    }


    if (eventModal) {
        eventModal.addEventListener('show.bs.modal', function (event) {
            try {
                const button = event.relatedTarget;
                const card = button.closest('.event-card');
                if (card) {
                    const title = card.querySelector('.card-title').innerText;
                    const description = card.querySelector('.card-text').innerText;
                    const imageSrc = card.querySelector('.card-img-top').src;
                    const locationText = card.querySelector('.text-muted').innerText.trim();

                    const searchQuery = encodeURIComponent(`${title} ${locationText}`);
                    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${searchQuery}`;

                    document.getElementById('modalTitle').innerText = title;
                    document.getElementById('modalDescription').innerText = description;
                    document.getElementById('modalImage').src = imageSrc;

                    const locationLink = document.getElementById('modalLocationLink');
                    if (locationLink) {
                        locationLink.innerText = locationText;
                        locationLink.href = mapsUrl;
                    }
                }
            } catch (error) { console.error("Modal Error:", error); }
        });
    }


    const gallerySearchInput = document.getElementById('gallerySearch');
    const gallerySearchBtn = document.getElementById('gallerySearchBtn');
    const galleryDropdownItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const galleryDropdownToggle = document.getElementById('dropdownBtn');

    if (galleryItems.length > 0) {
        let activeCategory = "All Events";

        const performGalleryFilter = () => {
            const searchTerm = gallerySearchInput ? gallerySearchInput.value.toLowerCase().trim() : "";
            galleryItems.forEach(item => {
                const title = item.querySelector('p').innerText.toLowerCase();
                const itemCategory = item.getAttribute('data-category');

                const matchesSearch = title.includes(searchTerm) || searchTerm === "";
                const matchesCategory = (activeCategory === "All Events") || (itemCategory === activeCategory);

                item.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
            });
        };

        if (gallerySearchBtn) gallerySearchBtn.addEventListener('click', performGalleryFilter);

        galleryDropdownItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                galleryDropdownItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                activeCategory = this.innerText.trim();
                if (galleryDropdownToggle) galleryDropdownToggle.innerText = activeCategory;
                performGalleryFilter();
            });
        });
    }


    const regForm = document.getElementById('registrationForm');
    if (regForm) {
        regForm.addEventListener('submit', function (e) {
            e.preventDefault();
            alert("Registration Successful!\nDetails sent to your email.");
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            if (modalInstance) modalInstance.hide();
            regForm.reset();
        });
    }
    if (window.location.pathname.includes('contact.php')) {
        const contactMap = document.getElementById('contactMap');
        if (contactMap) {
            const westernProvinceCenter = "6.8400,80.0000";
            const zoomLevel = "10";

            contactMap.src = `https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d506880.000000!2d80.0000!3d6.8400!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk`;
        }
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();


                const name = this.querySelector('input[type="text"]').value;
                const email = this.querySelector('input[type="email"]').value;
                const message = this.querySelector('textarea').value;

                if (name && email && message) {
                    alert(`Thank you, ${name}! Your message has been sent to the Event Western team.`);
                    this.reset();
                } else {
                    alert("Please fill in all fields before sending.");
                }
            });
        }
    }

    const postForm = document.getElementById('communityPostForm');
    const feedContainer = document.getElementById('communityFeed');

    if (postForm && feedContainer) {

        function loadLocalPosts() {
            const posts = JSON.parse(localStorage.getItem('community_posts')) || [];
            posts.forEach(content => {
                appendPost(content, false);
            });
        }

        function appendPost(content, save = true) {
            const newPost = document.createElement('div');
            newPost.className = 'card border-0 shadow-sm mb-4 rounded-4 post-card animate__animated animate__fadeInDown';
            newPost.innerHTML = `
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="https://i.pravatar.cc/50?u=guest" class="rounded-circle me-3 shadow-sm" alt="User">
                    <div>
                        <h6 class="mb-0 fw-bold">Guest User</h6>
                        <small class="text-muted">Just now • Western Province</small>
                    </div>
                    <button class="btn btn-light btn-sm ms-auto rounded-circle delete-post-btn"><i class="bi bi-trash text-danger"></i></button>
                </div>
                <p class="mb-3">${content}</p>
                <div class="d-flex gap-4 border-top pt-3 mt-2">
                    <button class="btn btn-link text-decoration-none text-secondary p-0 fw-bold like-btn"><i class="bi bi-heart me-1"></i> <span class="like-count">0</span> Likes</button>
                    <button class="btn btn-link text-decoration-none text-secondary p-0 fw-bold"><i class="bi bi-chat me-1"></i> 0 Comments</button>
                </div>
            </div>
        `;


            const likeBtn = newPost.querySelector('.like-btn');
            likeBtn.addEventListener('click', function () {
                const icon = this.querySelector('i');
                const count = this.querySelector('.like-count');
                if (icon.classList.contains('bi-heart')) {
                    icon.classList.replace('bi-heart', 'bi-heart-fill');
                    icon.classList.add('text-danger');
                    count.innerText = parseInt(count.innerText) + 1;
                } else {
                    icon.classList.replace('bi-heart-fill', 'bi-heart');
                    icon.classList.remove('text-danger');
                    count.innerText = parseInt(count.innerText) - 1;
                }
            });


            newPost.querySelector('.delete-post-btn').addEventListener('click', function () {
                newPost.remove();
                let posts = JSON.parse(localStorage.getItem('community_posts')) || [];
                posts = posts.filter(p => p !== content);
                localStorage.setItem('community_posts', JSON.stringify(posts));
            });

            feedContainer.prepend(newPost);

            if (save) {
                const posts = JSON.parse(localStorage.getItem('community_posts')) || [];
                posts.push(content);
                localStorage.setItem('community_posts', JSON.stringify(posts));
            }
        }


        postForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const content = document.getElementById('postContent').value.trim();

            if (content) {
                appendPost(content, true);
                postForm.reset();
            }
        });


        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const icon = this.querySelector('i');
                if (icon.classList.contains('bi-heart')) {
                    icon.classList.replace('bi-heart', 'bi-heart-fill');
                    icon.classList.add('text-danger');
                } else {
                    icon.classList.replace('bi-heart-fill', 'bi-heart');
                    icon.classList.remove('text-danger');
                }
            });
        });

        loadLocalPosts();
    }

});


const eventCollections = {

    'event_1': [
        'images/musical/aloka/aloka.jpg',
        'images/musical/aloka/1.jpg',
        'images/musical/aloka/2.jpg',
        'images/musical/aloka/3.jpg',
        'images/musical/aloka/4.jpg'

    ],
    'event_2': [
        'images/sports_tourement/flashmob.jpg',
        'images/sports_tourement/1.jpg',
        'images/sports_tourement/2.jpg',
        'images/sports_tourement/3.jpg'
    ],
    'event_3': [
        'images/Meetups/slexpo/01.png',
        'images/Meetups/slexpo/02.webp',
        'images/Meetups/slexpo/03.jpg'
    ],
    'event_4': [
        'images/Meetups/Foodg/food1.jpg'
    ],
    'event_5': [
        'images/Drama/hunuwataye/hang.jpg',
        'images/Drama/hunuwataye/hold.jpg'

    ],
    'event_6': [

        'images/big_match/blues/celebrate.jpg',
        'images/big_match/blues/cap.jpg',
        'images/big_match/blues/match.jpg',
        'images/big_match/blues/player.jpg'

    ],
    'event_7': [
        'images/big_match/maroons/baller.jpg',
        'images/big_match/maroons/cup.jpg',
        'images/big_match/maroons/cup2.jpg',
        'images/big_match/maroons/win.jpg'
    ],
    'event_8': [
        'images/Meetups/expediction/back.jpg',
        'images/Meetups/expediction/cover.jpg',
        'images/Meetups/expediction/guest.jpg'
    ],
    'event_9': [
        'images/musical/nadaga/1.jpg',
        'images/musical/nadaga/2.jpg',
        'images/musical/nadaga/3.jpg',
        'images/musical/nadaga/naadhagama.jpg'

    ],
    'event_10': [
        'images/Drama/sinhabahu/cover.jpg',
        'images/Drama/sinhabahu/drama.jpg'
    ],

};

window.openEventGallery = function (eventId, eventTitle) {
    const photoGrid = document.getElementById('photoGrid');
    const modalTitle = document.getElementById('galleryTitle');

    const dbPhotos = window.dynamicEventCollections ? window.dynamicEventCollections[eventId] || [] : [];
    const customPhotos = eventCollections[eventId] || [];
    const photos = [...new Set([...dbPhotos, ...customPhotos])];

    if (modalTitle) {
        modalTitle.innerText = (eventTitle ? eventTitle : eventId.toUpperCase()) + " Highlights";
    }

    if (photoGrid) {
        photoGrid.innerHTML = '';
        photos.forEach(src => {
            const col = document.createElement('div');
            col.className = 'col-6 col-md-4 col-lg-3';
            col.innerHTML = `
                <div class="card border-0 shadow-sm overflow-hidden">
                    <img src="${src}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                </div>`;
            photoGrid.appendChild(col);
        });
    }

    const myModal = new bootstrap.Modal(document.getElementById('photoGalleryModal'));
    myModal.show();
};

document.addEventListener('DOMContentLoaded', function () {
    for (const [evtId, customPhotos] of Object.entries(eventCollections)) {
        const badge = document.getElementById('badge-' + evtId);
        if (badge) {
            const dbPhotos = window.dynamicEventCollections ? window.dynamicEventCollections[evtId] || [] : [];
            const totalPhotos = new Set([...dbPhotos, ...customPhotos]).size;
            badge.innerText = `View ${totalPhotos} Photos`;
        }
    }
});
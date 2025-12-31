

async function loadComponent(id, path) {
  const container = document.getElementById(id);
  if (!container) {
    console.error(`Container #${id} not found`);
    return;
  }

  try {
    // Add timestamp to prevent caching during development
    const noCachePath = `${path}?t=${new Date().getTime()}`;
    const response = await fetch(noCachePath);
    if (!response.ok) throw new Error(`Failed to load ${path}: ${response.statusText}`);
    container.innerHTML = await response.text();
    console.log(`Loaded ${id} from ${path}`);

    // Trigger specific logic for components
    if (id === 'hero') {
        fetchHeroData();
    }
    if (id === 'about') {
        fetchAboutData();
    }
    if (id === 'chairperson') {
        fetchChairpersonData();
    }
  } catch (error) {
    console.error(`Error loading component ${id}:`, error);
    container.innerHTML = `<div class="alert alert-danger">
      <strong>Error loading ${id}:</strong> ${error.message} <br>
      <small>Ensure you are opening <code>http://localhost:3000/src/</code> and NOT <code>file://...</code></small>
    </div>`;
  }
}

async function fetchHeroData() {
    try {
        // Fetch from Laravel API (assuming port 8000)
        const response = await fetch('http://localhost:8000/api/hero');
        if (!response.ok) throw new Error('Failed to fetch hero data');
        
        const data = await response.json();
        
        // Update DOM elements if they exist
        const set = (id, html) => { 
            const el = document.getElementById(id); 
            if (el) el.innerHTML = html; 
        };
        
        if (data.party_name) set('hero-party-name', data.party_name);
        if (data.title) set('hero-title', data.title);
        if (data.subtitle) set('hero-subtitle', data.subtitle);
        if (data.primary_button_text) set('hero-btn-primary', data.primary_button_text);
        if (data.secondary_button_text) set('hero-btn-secondary', data.secondary_button_text);
        
        // Handle Statistics
        const updateStat = (id, rawValue) => {
            const el = document.getElementById(id);
            if (!el || !rawValue) return;
            
            // Extract number and suffix (e.g., "50K+" -> number: 50, suffix: "K+")
            const numMatch = rawValue.match(/(\d+)/);
            const num = numMatch ? numMatch[0] : 0;
            const suffix = rawValue.replace(num, '');
            
            el.setAttribute('data-target', num);
            el.setAttribute('data-suffix', suffix);
            el.innerText = '0' + suffix; // Reset for animation
        };

        updateStat('hero-stat-members', data.stat_members);
        updateStat('hero-stat-provinces', data.stat_provinces);
        updateStat('hero-stat-programs', data.stat_programs);
        
        // Re-run counters if they were already initialized or wait for the intersection observer
        // Since we reset innerText, the IntersectionObserver will trigger correctly IF it's observing.
        // But initCounters() might have already run and unobserved.
        // Let's just call initCounters() again to be safe.
        initCounters();

        if (data.image_url) {
            const img = document.getElementById('hero-image');
            if (img) img.src = data.image_url;
        }

    } catch (e) {
        console.warn('Could not load dynamic hero data, falling back to static content.', e);
    }
}

async function fetchAboutData() {
    try {
        const response = await fetch('http://localhost:8000/api/about');
        if (!response.ok) throw new Error('Failed to fetch about data');
        
        const data = await response.json();
        
        const set = (id, html) => { 
            const el = document.getElementById(id); 
            if (el) el.innerHTML = html; 
        };
        
        if (data.header_badge) set('about-header-badge', data.header_badge);
        if (data.header_title) set('about-header-title', data.header_title);
        if (data.header_description) set('about-header-description', data.header_description);
        
        if (data.feature_1_title) set('about-feature-1-title', data.feature_1_title);
        if (data.feature_1_description) set('about-feature-1-desc', data.feature_1_description);
        
        if (data.feature_2_title) set('about-feature-2-title', data.feature_2_title);
        if (data.feature_2_description) set('about-feature-2-desc', data.feature_2_description);
        
        if (data.feature_3_title) set('about-feature-3-title', data.feature_3_title);
        if (data.feature_3_description) set('about-feature-3-desc', data.feature_3_description);
        
        if (data.banner_title) set('about-banner-title', data.banner_title);
        if (data.banner_description) set('about-banner-desc', data.banner_description);

    } catch (error) {
        console.error('Error fetching about data:', error);
    }
}

async function fetchChairpersonData() {
    try {
        const response = await fetch('http://localhost:8000/api/chairperson-message');
        if (!response.ok) throw new Error('Failed to fetch chairperson message');
        
        const data = await response.json();
        
        const set = (id, html) => { 
            const el = document.getElementById(id); 
            if (el) el.innerHTML = html; 
        };
        
        if (data.header_badge) set('chairperson-header-badge', data.header_badge);
        if (data.header_title) set('chairperson-header-title', data.header_title);
        
        if (data.image_url) {
            const img = document.getElementById('chairperson-image');
            if (img) img.src = data.image_url;
        }
        
        if (data.message_greeting) set('chairperson-message-greeting', data.message_greeting);
        
        if (data.message_content && Array.isArray(data.message_content)) {
            const paragraphsDiv = document.getElementById('chairperson-message-paragraphs');
            if (paragraphsDiv) {
                paragraphsDiv.innerHTML = data.message_content
                    .map(p => `<p class="mb-4 text-secondary">${p}</p>`)
                    .join('');
            }
        }
        
        if (data.signature_greeting) set('chairperson-signature-greeting', data.signature_greeting);
        if (data.chairperson_name) set('chairperson-name', data.chairperson_name);
        if (data.chairperson_title) set('chairperson-title', data.chairperson_title);
        
        if (data.philosophy_text) set('chairperson-philosophy', data.philosophy_text);
        if (data.commitment_text) set('chairperson-commitment', data.commitment_text);

    } catch (error) {
        console.error('Error fetching chairperson message data:', error);
    }
}

// Helper to control gallery carousel via inline onclick
window.setGalleryIndex = function(index) {
    const carouselEl = document.querySelector('#galleryCarousel');
    if (window.bootstrap && carouselEl) {
        const carousel =  window.bootstrap.Carousel.getOrCreateInstance(carouselEl);
        carousel.to(index);
    }
};

// Check for Registration Success Flag (Main Entry Point Logic)
document.addEventListener("DOMContentLoaded", () => {
    // Load components
    loadComponent("navbar", "components/navbar.html");
    loadComponent("hero", "components/hero.html");
    loadComponent("about", "components/about.html");
    loadComponent("chairperson", "components/chairperson_message.html");
    loadComponent("values", "components/values.html");
    loadComponent("program", "components/program.html");
    loadComponent("coverage", "components/indonesia_coverage.html");
    loadComponent("news", "components/news.html");
    loadComponent("gallery", "components/gallery.html");
    loadComponent("footer", "components/footer.html");

    // Success Modal Logic
    const regSuccess = localStorage.getItem('registrationSuccess');
    if (regSuccess) {
        // Wait slightly for Bootstrap to load
        setTimeout(() => {
            const successModalEl = document.getElementById('successModal');
            if (successModalEl && window.bootstrap) {
                const savedName = localStorage.getItem('registrantName');
                if (savedName) {
                    const nameSpan = document.getElementById('regName');
                    if (nameSpan) nameSpan.textContent = `, ${savedName}`;
                }

                const modal = new bootstrap.Modal(successModalEl);
                modal.show();
            }
            // Clear flags
            localStorage.removeItem('registrationSuccess');
            localStorage.removeItem('registrantName');
        }, 1000); 
    }

    // Back to Top Button Logic
    const backToTopBtn = document.getElementById("backToTop");
    
    if (backToTopBtn) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add("show");
            } else {
                backToTopBtn.classList.remove("show");
            }
        });

        backToTopBtn.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }
});

// Stats Counter Animation
function initCounters() {
    const counters = document.querySelectorAll('.counter-animate');
    const speed = 200; 

    const animate = (counter) => {
        const value = +counter.getAttribute('data-target');
        const data = +counter.innerText.replace(/\D/g, ''); 
        const suffix = counter.getAttribute('data-suffix') || '';
        
        const time = value / speed;

        if (data < value) {
            const increment = Math.ceil(value / 100); 
            counter.innerText = (data + increment) + suffix;
            setTimeout(() => animate(counter), 30);
        } else {
            counter.innerText = value + suffix;
        }
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                // Reset to 0 before animating to handle reload/re-entry
                counter.innerText = '0' + (counter.getAttribute('data-suffix') || ''); 
                animate(counter);
                // We DON'T unobserve if we want it to run every time it enters view, 
                // but user said "every time reload". 
                // However, observer is good practice. To satisfy "reload", 
                // normal behavior is enough.
                observer.unobserve(counter); 
            }
        });
    }, { threshold: 0.5 }); 

    counters.forEach(counter => {
        observer.observe(counter);
    });
}
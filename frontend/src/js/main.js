

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
    if (id === 'values') fetchValuesData();
    if (id === 'program') fetchProgramData();
    if (id === 'coverage') fetchCoverageData();
    if (id === 'news') fetchNewsData();
    if (id === 'aspirations') initAspirationForm();
    if (id === 'gallery') fetchGalleryData();
    if (id === 'footer') fetchSettingsData();
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
    loadComponent("aspirations", "components/aspirations.html");
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

/* CMS Fetch Functions */
async function fetchValuesData() {
    try {
        const r = await fetch('http://localhost:8000/api/values');
        if(!r.ok) return;
        const data = await r.json();
        const container = document.querySelector('#values-section .row.g-4');
        if(container && data.length) {
            container.innerHTML = data.sort((a,b)=>a.order-b.order).map(item => `
            <div class="col-lg-3 col-md-6">
                <div class="value-card bg-white p-4 h-100 rounded-4 border hover-shadow d-block text-decoration-none">
                    <div class="icon-box rounded-3 d-flex align-items-center justify-content-center mb-4 text-white bg-danger" style="width:48px;height:48px;overflow:hidden;">
                       ${item.icon ? `<img src="http://localhost:8000/storage/${item.icon}" style="width:100%;height:100%;object-fit:contain;">` : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'}
                    </div>
                    <h5 class="fw-bold mb-3">${item.title}</h5>
                    <p class="text-secondary small mb-0">${item.description}</p>
                </div>
            </div>`).join('');
        }
    } catch(e){console.warn(e);}
}

async function fetchProgramData() {
    try {
        const r = await fetch('http://localhost:8000/api/programs');
        if(!r.ok) return;
        const data = await r.json();
        const container = document.querySelector('#program-section .row.g-4');
        if(container && data.length) {
            container.innerHTML = data.map(item => `
            <div class="col-lg-6">
                <div class="program-card bg-white p-5 rounded-4 border shadow-sm h-100 position-relative overflow-hidden w-100">
                    <div class="position-absolute top-0 end-0 bg-secondary opacity-25 rounded-bottom-start-5" style="width: 80px; height: 80px; border-bottom-left-radius: 100% !important;"></div>
                    <div class="d-flex flex-column h-100">
                        <div class="icon-box bg-danger text-white rounded-3 d-flex align-items-center justify-content-center mb-4" style="width: 56px; height: 56px; overflow:hidden;">
                            ${item.icon ? `<img src="http://localhost:8000/storage/${item.icon}" style="width:100%;height:100%;object-fit:contain;">` : '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg>'}
                        </div>
                        <h4 class="fw-bold mb-3">${item.title}</h4>
                        <p class="text-secondary mb-4 flex-grow-1">${item.description}</p>
                        ${item.stats_text ? `
                        <div class="d-flex align-items-center gap-2 text-danger small fw-semibold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/></svg>
                            <span>${item.stats_text}</span>
                        </div>` : ''}
                        <a href="${item.action_url||'#'}" class="text-danger fw-bold text-decoration-none learn-more-link">${item.action_text||'Pelajari Lebih Lanjut'} &rarr;</a>
                    </div>
                </div>
            </div>`).join('');
        }
    } catch(e){console.warn(e);}
}

async function fetchCoverageData() {
    try {
        const r = await fetch('http://localhost:8000/api/region-stats');
        if(!r.ok) return;
        const data = await r.json();
        const container = document.querySelector('#coverage-section .region-stats .row');
        if(container && data.length) {
            container.innerHTML = data.map(item => `
            <div class="col-lg-4 col-md-6">
                <div class="p-4 rounded-4 h-100 border border-white border-opacity-10 region-card position-relative overflow-hidden" style="background-color: rgba(255, 255, 255, 0.05);">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">${item.region_name}</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-geo-alt opacity-75" viewBox="0 0 16 16"><path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/><path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="opacity-75">Kantor Cabang:</span>
                        <span class="fw-bold">${item.branch_count}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 small">
                        <span class="opacity-75">Anggota:</span>
                        <span class="fw-bold">${item.member_count_text}</span>
                    </div>
                    <hr class="border-white opacity-10 my-3">
                    <span class="small opacity-50" style="font-size: 0.75rem;">Status: ${item.status}</span>
                </div>
            </div>`).join('');
        }
    } catch(e){console.warn(e);}
}

async function fetchNewsData() {
    try {
        const r = await fetch('http://localhost:8000/api/articles');
        if(!r.ok) return;
        const data = await r.json();
        const container = document.querySelector('#news-section .row.g-4');
        if(container && data.length) {
            container.innerHTML = data.map(item => `
            <div class="col-lg-4 col-md-6">
                <div class="news-card h-100 bg-white rounded-4 border overflow-hidden d-flex flex-column hover-shadow">
                    <div class="news-img-wrapper position-relative overflow-hidden bg-light" style="height: 240px;">
                        <img src="${item.image ? 'http://localhost:8000/storage/'+item.image : 'https://placehold.co/600x400'}" class="w-100 h-100 object-fit-cover">
                        ${item.badge ? `<span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill fw-medium">${item.badge}</span>` : ''}
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="d-flex align-items-center gap-2 text-secondary small mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>
                            <span>${new Date(item.published_date).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'})}</span>
                        </div>
                        <h5 class="fw-bold mb-3 lh-base">${item.title}</h5>
                        <p class="text-secondary small mb-4 flex-grow-1">${item.excerpt || ''}</p>
                        <a href="#" class="d-inline-flex align-items-center text-danger fw-semibold text-decoration-none read-more-link">
                            Baca Selengkapnya <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/></svg>
                        </a>
                    </div>
                </div>
            </div>`).join('');
        }
    } catch(e){console.warn(e);}
}

async function fetchGalleryData() {
    try {
        const r = await fetch('http://localhost:8000/api/gallery');
        if(!r.ok) return;
        const data = await r.json();
        const container = document.querySelector('#gallery-section .row.g-4');
        const carouselInner = document.querySelector('#galleryCarousel .carousel-inner');
        
        if(container && data.length) {
            container.innerHTML = data.map((item, i) => `
            <div class="col-lg-4 col-md-6">
                <div class="gallery-card rounded-4 overflow-hidden position-relative h-100 cursor-pointer" style="min-height: 300px;" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="setGalleryIndex(${i})">
                    <img src="http://localhost:8000/storage/${item.image}" alt="${item.title}" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
                    <div class="gradient-overlay position-absolute bottom-0 start-0 w-100 p-4 text-white d-flex flex-column justify-content-end h-100">
                        <h4 class="fw-bold mb-1">${item.title}</h4>
                        <p class="small opacity-75 mb-0">${item.category || ''}</p>
                    </div>
                </div>
            </div>`).join('');
            
            if(carouselInner) {
                carouselInner.innerHTML = data.map((item, i) => `
                <div class="carousel-item ${i===0 ? 'active' : ''}">
                    <img src="http://localhost:8000/storage/${item.image}" class="d-block w-100 rounded-4" alt="${item.title}">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 class="fw-bold">${item.title}</h3>
                        <p>${item.caption || ''}</p>
                    </div>
                </div>`).join('');
            }
        }
    } catch(e){console.warn(e);}
}

async function fetchSettingsData() {
    try {
        const r = await fetch('http://localhost:8000/api/settings');
        if(!r.ok) return;
        const settings = await r.json();
        
        const addrEl = document.getElementById('footer-address');
        if(addrEl && settings.address) addrEl.innerText = settings.address;
        
        const phoneEl = document.getElementById('footer-phone');
        if(phoneEl && settings.phone) phoneEl.innerText = settings.phone;
        
        const emailEl = document.getElementById('footer-email');
        if(emailEl && settings.email) emailEl.innerText = settings.email;
    } catch(e){console.warn(e);}
}

function initAspirationForm() {
    const form = document.getElementById('aspirationForm');
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('aspSubmitBtn');
        const success = document.getElementById('aspSuccess');
        const successMsg = document.getElementById('aspSuccessMsg');

        btn.disabled = true;
        btn.innerText = 'Mengirim...';

        const formData = {
            name: form.name.value,
            email: form.email.value,
            subject: form.subject.value,
            message: form.message.value
        };

        try {
            const r = await fetch('http://localhost:8000/api/aspirations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await r.json();

            if (r.ok) {
                success.classList.remove('d-none');
                successMsg.innerText = data.message;
                form.reset();
                btn.innerText = 'Kirim Aspirasi';
                btn.disabled = false;
            } else {
                alert('Gagal mengirim aspirasi. Periksa kembali form Anda.');
                btn.innerText = 'Kirim Aspirasi';
                btn.disabled = false;
            }
        } catch (error) {
            console.error(error);
            alert('Tidak dapat terhubung ke server.');
            btn.innerText = 'Kirim Aspirasi';
            btn.disabled = false;
        }
    });
}
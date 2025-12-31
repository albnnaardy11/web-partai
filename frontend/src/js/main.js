

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
        initCounters();
    }
  } catch (error) {
    console.error(`Error loading component ${id}:`, error);
    container.innerHTML = `<div class="alert alert-danger">
      <strong>Error loading ${id}:</strong> ${error.message} <br>
      <small>Ensure you are opening <code>http://localhost:3000/src/</code> and NOT <code>file://...</code></small>
    </div>`;
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
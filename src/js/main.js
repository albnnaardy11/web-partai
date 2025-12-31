

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

// Load components
document.addEventListener("DOMContentLoaded", () => {
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
});
<!-- Animated Intro Component - Converted from React to Blade -->
<div id="intro-loading" class="fixed inset-0 z-50 flex items-center justify-center bg-gradient-to-b from-cyan-50 via-white to-white transition-opacity duration-800" style="display: none;">

  <!-- Animated Background Particles -->
  <div class="absolute inset-0 overflow-hidden">
    <!-- Background bubbles matching main design -->
    <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-cyan-100 blur-3xl opacity-60 animate-pulse"></div>
    <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-cyan-200 blur-3xl opacity-40 animate-pulse"></div>

    <!-- Floating particles -->
    <div class="particles-container">
      <!-- Will be populated by JavaScript -->
    </div>
  </div>

  <div class="relative z-10 text-center">
    <!-- Step 1: Logo Animation -->
    <div id="logo-section" class="mb-8">
      <div class="relative">
        <div class="text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 via-cyan-500 to-cyan-400 flex justify-center relative">
          <span class="letter-cinematic" style="animation-delay: 0.025s;">I</span>
          <span class="letter-cinematic" style="animation-delay: 0.05s;">N</span>
          <span class="letter-cinematic" style="animation-delay: 0.075s;">F</span>
          <span class="letter-cinematic" style="animation-delay: 0.1s;">E</span>
          <span class="letter-cinematic" style="animation-delay: 0.125s;">S</span>
          <span class="letter-cinematic" style="animation-delay: 0.15s;">T</span>
          <!-- Matrix rain effect -->
          <div class="matrix-rain"></div>
        </div>
        <div class="text-5xl font-bold mt-6 flex justify-center relative year-container">
          <!-- Holographic 2026 with laser scan effect -->
          <div class="year-hologram">
            <span class="year-digit-holo" style="animation-delay: 0.3s;">2</span>
            <span class="year-digit-holo" style="animation-delay: 0.35s;">0</span>
            <span class="year-digit-holo" style="animation-delay: 0.4s;">2</span>
            <span class="year-digit-holo" style="animation-delay: 0.45s;">6</span>
            <!-- Laser scan lines -->
            <div class="laser-scan"></div>
            <div class="laser-scan-2"></div>
            <!-- Hologram glitch effects -->
            <div class="holo-glitch-1"></div>
            <div class="holo-glitch-2"></div>
            <!-- Energy particles -->
            <div class="energy-particle" style="animation-delay: 0.3s;"></div>
            <div class="energy-particle" style="animation-delay: 0.375s;"></div>
            <div class="energy-particle" style="animation-delay: 0.45s;"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 2: Floating Icons -->
    <div id="icons-section" class="flex justify-center space-x-8 mb-8">
      <div class="icon-item text-cyan-600 text-4xl" style="animation-delay: 0.7s;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="4" y="4" width="16" height="16" rx="2"/>
          <rect x="9" y="9" width="6" height="6"/>
          <path d="m9 1 3 3 3-3"/>
          <path d="m9 23 3-3 3 3"/>
          <path d="m1 9 3 3-3 3"/>
          <path d="m23 9-3 3 3 3"/>
        </svg>
      </div>
      <div class="icon-item text-orange-500 text-4xl" style="animation-delay: 0.8s;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="16 18 22 12 16 6"/>
          <polyline points="8 6 2 12 8 18"/>
        </svg>
      </div>
      <div class="icon-item text-yellow-500 text-4xl" style="animation-delay: 0.9s;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
        </svg>
      </div>
      <div class="icon-item text-cyan-400 text-4xl" style="animation-delay: 1.0s;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m9 11 3 3 8-8"/>
          <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9"/>
          <circle cx="12" cy="12" r="1"/>
        </svg>
      </div>
      <div class="icon-item text-orange-500 text-4xl" style="animation-delay: 1.1s;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
          <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
          <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
          <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
        </svg>
      </div>
      <div class="icon-item text-cyan-600 text-4xl" style="animation-delay: 1.2s;">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="12 2 15.09 8.26 22 9 17 14.74 18.18 21.02 12 17.77 5.82 21.02 7 14.74 2 9 8.91 8.26 12 2"/>
        </svg>
      </div>
    </div>

    <!-- Step 3: Loading Bar -->
    <div id="loading-section" class="mt-12 w-64 mx-auto opacity-0">
      <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
        <div id="progress-bar" class="h-full bg-gradient-to-r from-cyan-600 via-cyan-500 to-cyan-400 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
      </div>
      <p class="text-center text-gray-500 text-sm mt-2 loading-text opacity-0">
        Preparing your experience...
      </p>
    </div>
  </div>

  <!-- Corner Decorations -->
  <div class="absolute top-10 left-10 corner-decoration-1">
    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-cyan-400 opacity-30">
      <polygon points="12 2 15.09 8.26 22 9 17 14.74 18.18 21.02 12 17.77 5.82 21.02 7 14.74 2 9 8.91 8.26 12 2"/>
    </svg>
  </div>
  <div class="absolute bottom-10 right-10 corner-decoration-2">
    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-400 opacity-30">
      <path d="m9 11 3 3 8-8"/>
      <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9"/>
      <circle cx="12" cy="12" r="1"/>
    </svg>
  </div>
</div>

<style>
/* Animation Keyframes */
@keyframes cinematicEntry {
  0% {
    transform: scale(0.1) translateY(-150px) rotateX(-90deg);
    opacity: 0;
    filter: blur(30px) brightness(0) hue-rotate(180deg);
    text-shadow: none;
  }
  30% {
    transform: scale(1.4) translateY(20px) rotateX(-20deg);
    opacity: 0.6;
    filter: blur(8px) brightness(1.8) hue-rotate(0deg);
    text-shadow:
      0 0 40px rgba(34, 211, 238, 0.9),
      0 0 80px rgba(6, 182, 212, 0.7),
      0 10px 0 rgba(6, 182, 212, 0.3);
  }
  60% {
    transform: scale(0.9) translateY(-10px) rotateX(10deg);
    opacity: 1;
    filter: blur(2px) brightness(1.4);
    text-shadow:
      0 0 30px rgba(34, 211, 238, 0.8),
      0 0 60px rgba(6, 182, 212, 0.6),
      0 8px 0 rgba(6, 182, 212, 0.4);
  }
  80% {
    transform: scale(1.05) translateY(5px) rotateX(-5deg);
    filter: blur(0px) brightness(1.2);
    text-shadow:
      0 0 25px rgba(34, 211, 238, 0.7),
      0 0 50px rgba(6, 182, 212, 0.5),
      0 6px 0 rgba(6, 182, 212, 0.3);
  }
  100% {
    transform: scale(1) translateY(0) rotateX(0deg);
    opacity: 1;
    filter: blur(0px) brightness(1);
    text-shadow:
      0 0 20px rgba(34, 211, 238, 0.6),
      0 0 40px rgba(6, 182, 212, 0.4),
      0 4px 0 rgba(6, 182, 212, 0.2);
  }
}

@keyframes hologramMaterialize {
  0% {
    transform: scale(0) rotateY(-90deg);
    opacity: 0;
    filter: blur(15px) brightness(0.3);
  }
  25% {
    transform: scale(0.5) rotateY(-45deg);
    opacity: 0.4;
    filter: blur(8px) brightness(0.7);
  }
  50% {
    transform: scale(1.2) rotateY(15deg);
    opacity: 0.8;
    filter: blur(3px) brightness(1.5);
  }
  75% {
    transform: scale(0.9) rotateY(-5deg);
    opacity: 1;
    filter: blur(1px) brightness(1.2);
  }
  100% {
    transform: scale(1) rotateY(0deg);
    opacity: 1;
    filter: blur(0px) brightness(1);
  }
}

@keyframes waveExpansion {
  0% {
    transform: scale(0);
    opacity: 0.8;
  }
  50% {
    transform: scale(2);
    opacity: 0.4;
  }
  100% {
    transform: scale(4);
    opacity: 0;
  }
}

@keyframes matrixRain {
  0% { transform: translateY(-100vh); opacity: 0; }
  10% { opacity: 1; }
  90% { opacity: 1; }
  100% { transform: translateY(100vh); opacity: 0; }
}

@keyframes laserScan {
  0% {
    transform: translateX(-200px);
    opacity: 0;
  }
  30% {
    opacity: 1;
  }
  70% {
    opacity: 1;
  }
  100% {
    transform: translateX(200px);
    opacity: 0;
  }
}

@keyframes holoGlitch {
  0%, 90%, 100% { transform: translate(0); }
  20% { transform: translate(-2px, 2px); }
  40% { transform: translate(-2px, -2px); }
  60% { transform: translate(2px, 2px); }
  80% { transform: translate(2px, -2px); }
}

@keyframes energyParticle {
  0% {
    transform: scale(0) rotate(0deg);
    opacity: 0;
  }
  20% {
    transform: scale(1) rotate(90deg);
    opacity: 1;
  }
  80% {
    transform: scale(1.5) rotate(270deg);
    opacity: 0.8;
  }
  100% {
    transform: scale(0) rotate(360deg);
    opacity: 0;
  }
}

@keyframes iconSuperBounce {
  0% {
    transform: scale(0) translateY(100px) rotate(-720deg);
    opacity: 0;
  }
  50% {
    transform: scale(1.4) translateY(-30px) rotate(-360deg);
    opacity: 1;
  }
  70% {
    transform: scale(0.8) translateY(15px) rotate(0deg);
  }
  85% {
    transform: scale(1.1) translateY(-8px);
  }
  100% {
    transform: scale(1) translateY(0) rotate(0deg);
    opacity: 1;
  }
}

@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

@keyframes floatParticle {
  0% { transform: translate(0, 0) scale(0); opacity: 0; }
  50% { opacity: 0.6; }
  100% { transform: translate(var(--dx, 0), var(--dy, 0)) scale(0); opacity: 0; }
}

@keyframes rotateCorner {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Animation Classes */
.letter-cinematic {
  display: inline-block;
  opacity: 0;
  position: relative;
  animation: cinematicEntry 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
}

.year-container {
  perspective: 1000px;
}

.year-hologram {
  position: relative;
  transform-style: preserve-3d;
}

.year-digit-holo {
  display: inline-block;
  opacity: 0;
  position: relative;
  font-weight: 900;
  background: linear-gradient(45deg,
    #f97316,
    #eab308,
    #f97316);
  -webkit-background-clip: text;
  background-clip: text;
  color: #f97316;
  animation: hologramMaterialize 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
  text-shadow:
    0 0 30px rgba(249, 115, 22, 0.8),
    0 0 60px rgba(234, 179, 8, 0.6),
    0 0 90px rgba(249, 115, 22, 0.4);
}

.matrix-rain {
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  width: 2px;
  height: 100px;
  background: linear-gradient(to bottom,
    transparent,
    rgba(34, 211, 238, 0.8),
    transparent);
  animation: matrixRain 2s ease-in-out infinite;
  animation-delay: 0.5s;
}

.laser-scan {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: linear-gradient(90deg,
    transparent,
    rgba(249, 115, 22, 1),
    rgba(234, 179, 8, 1),
    rgba(249, 115, 22, 1),
    transparent);
  animation: laserScan 1.5s ease-in-out infinite;
  animation-delay: 0.8s;
  box-shadow: 0 0 20px rgba(249, 115, 22, 0.8);
}

.laser-scan-2 {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg,
    transparent,
    rgba(234, 179, 8, 0.8),
    transparent);
  animation: laserScan 2s ease-in-out infinite reverse;
  animation-delay: 1.2s;
}

.holo-glitch-1 {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg,
    transparent 30%,
    rgba(249, 115, 22, 0.1) 31%,
    rgba(249, 115, 22, 0.1) 32%,
    transparent 33%);
  animation: holoGlitch 0.3s ease-in-out infinite;
  animation-delay: 1.5s;
}

.holo-glitch-2 {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(-45deg,
    transparent 60%,
    rgba(234, 179, 8, 0.1) 61%,
    rgba(234, 179, 8, 0.1) 62%,
    transparent 63%);
  animation: holoGlitch 0.4s ease-in-out infinite;
  animation-delay: 1.8s;
}

.energy-particle {
  position: absolute;
  width: 8px;
  height: 8px;
  background: radial-gradient(circle,
    rgba(249, 115, 22, 1) 0%,
    rgba(234, 179, 8, 0.8) 50%,
    transparent 100%);
  border-radius: 50%;
  top: 20%;
  left: 20%;
  animation: energyParticle 2s ease-in-out infinite;
  box-shadow: 0 0 15px rgba(249, 115, 22, 0.8);
}

.icon-item {
  opacity: 0;
  animation: iconSuperBounce 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
}

.loading-text {
  animation: fadeInUp 0.5s ease-out 0.3s forwards;
}

.corner-decoration-1 {
  animation: rotateCorner 20s linear infinite;
}

.corner-decoration-2 {
  animation: rotateCorner 15s linear infinite reverse;
}

.particle {
  position: absolute;
  width: 4px;
  height: 4px;
  background: #22d3ee;
  border-radius: 50%;
  opacity: 0.4;
  animation: floatParticle 3s ease-in-out infinite;
}

/* Hide class for fade out */
#intro-loading.hide {
  opacity: 0;
  pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const introLoading = document.getElementById('intro-loading');

  // Check if this is after a successful login
  const showIntroAfterLogin = sessionStorage.getItem('showIntroAfterLogin');

  // Only show intro after successful login
  if (!showIntroAfterLogin) {
    return;
  }

  // Remove the session flag so it doesn't show again until next login
  sessionStorage.removeItem('showIntroAfterLogin');

  // Show the intro
  introLoading.style.display = 'flex';

  const logoSection = document.getElementById('logo-section');
  const iconsSection = document.getElementById('icons-section');
  const loadingSection = document.getElementById('loading-section');
  const progressBar = document.getElementById('progress-bar');
  const particlesContainer = document.querySelector('.particles-container');

  // Generate floating particles
  function createParticles() {
    for (let i = 0; i < 20; i++) {
      const particle = document.createElement('div');
      particle.className = 'particle';
      particle.style.left = Math.random() * 100 + '%';
      particle.style.top = Math.random() * 100 + '%';
      particle.style.setProperty('--dx', (Math.random() * 100 - 50) + 'px');
      particle.style.setProperty('--dy', (Math.random() * 100 - 50) + 'px');
      particle.style.animationDelay = Math.random() * 2 + 's';
      particlesContainer.appendChild(particle);
    }
  }

  // Initialize particles
  createParticles();

  // Animation sequence
  let progress = 0;

  // Logo letters start immediately (controlled by CSS animation delays)
  // Icons start after letters finish (around 1.3s, controlled by CSS)

  // Step 3: Show loading bar after icons finish
  setTimeout(() => {
    loadingSection.style.opacity = '1';

    // Start progress animation
    const progressInterval = setInterval(() => {
      progress += Math.random() * 15 + 10;
      if (progress >= 100) {
        progress = 100;
        clearInterval(progressInterval);

        // Hide intro after loading complete
        setTimeout(() => {
          introLoading.classList.add('hide');
          setTimeout(() => {
            introLoading.style.display = 'none';
          }, 400);
        }, 300);
      }
      progressBar.style.width = progress + '%';
    }, 40);

  }, 1400); // Wait for all icons to finish animating
});
</script>
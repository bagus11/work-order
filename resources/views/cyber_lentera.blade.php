<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CyberLentera Login</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <!-- Left Panel -->
    <div class="left-panel">
      <div class="logo">
        <img src="https://i.imgur.com/9MvHWVx.png" alt="Wtree Logo" />
        <span>Wtree</span>
      </div>
      <div class="circle-image-wrapper">
        <div class="glow-ring"></div>
        <img
          src="{{URL::asset('logos.png')}}"
          alt="Lantern in desert"
          class="center-image"
        />
      </div>
      <div class="branding">
        <h1>Cyber<span>Lentera</span></h1>
        <p>Digital Platform Ecosystem</p>
      </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
      <canvas id="particle-canvas"></canvas>
      <form class="login-form" style="padding-left: 50px; padding-right: 50px">
        <h2 class="title">
          Welcome to
          <img
            src="{{URL::asset('logos2.png')}}"
            alt="Lock Icon"
            class="lock-icon"
          />
          CyberLentera
        </h2>
        <p class="subtitle">Enter login credentials below</p>

        <label for="username" class="input-label">Username or email</label>
        <input style="border-radius: 30px"
          type="text"
          id="username"
          name="username"
          placeholder="Username or email"
          required
          class="input-field"
        />
        <label for="password" class="input-label">Password</label>
        <input style="border-radius: 30px"
          type="password"
          id="password"
          name="password"
          placeholder="Password"
          required
          class="input-field"
        />

        <button type="submit" class="sign-in-btn">Sign in</button>
      </form>
    </div>
  </div>
</body>
</html>
<style>
 @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

* {
  box-sizing: border-box;
}

body,
html {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: 'Poppins', sans-serif;
  background: #29476b;
  color: white;
}

/* Container with left & right panels side by side */
.container {
  display: flex;
  height: 100vh;
  width: 100%;
  overflow: auto;
  animation: fadeIn 1s ease-in-out;
}

/* LEFT PANEL */
.left-panel {
  background-color: #171717;
  flex: 1;
  padding: clamp(20px, 5vw, 40px);
  /* border-radius: 0 0 0 30px; */
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  animation: slideInLeft 1s ease-out;
}

/* Wtree logo top-left */
.logo {
  display: flex;
  align-items: center;
  gap: 6px;
  font-weight: 600;
  font-size: 24px;
  color: #bbbbbb;
  user-select: none;
  transition: color 0.3s ease;
}

.logo:hover {
  color: #ffffff;
}

.logo img {
  width: 29px;
  height: 29px;
  transition: transform 0.3s ease;
}

.logo:hover img {
  transform: scale(1.1);
}

/* Circular image with glowing ring */
.circle-image-wrapper {
  position: relative;
  width: min(400px, 80vw);
  height: min(400px, 80vw);
  margin: 0 auto;
}

.glow-ring {
  position: absolute;
  width: min(450px, 90vw);
  height: min(450px, 90vw);
  border-radius: 50%;
  background: radial-gradient(
    circle,
    rgba(242, 156, 46, 0.8) 40%,
    transparent 88%
  );
  filter: blur(24px);
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
  animation: pulse 2s infinite ease-in-out;
}
.center-image {
  position: absolute;
  top: 50%;
  left: 50%;
  width: calc(100% - 50px); /* subtract border width 25*2 */
  height: calc(100% - 50px);
  border-radius: 50%;
  border: 25px solid #f59e33;
  object-fit: cover;
  object-position: center;
  filter: drop-shadow(0 0 18px rgba(245, 158, 51, 0.8));
  transform: translate(-50%, -50%);
  z-index: 2;
  background: transparent;
  transition: transform 0.3s ease, filter 0.3s ease;
  display: block;
}

.center-image:hover {
  transform: translate(-50%, -50%) scale(1.05);
  filter: drop-shadow(0 0 24px rgba(245, 158, 51, 1));
}

/* Branding bottom left */
.branding {
  text-align: left;
  color: white;
  user-select: none;
  animation: slideInUp 1s ease-out 0.5s both;
}

.branding h1 {
  font-size: 36px;
  font-weight: 900;
  margin-top: 0;
  margin-bottom: 8px;
  transition: transform 0.3s ease;
}

.branding h1:hover {
  transform: translateY(-5px);
}

.branding h1 span {
  color: #f59e33;
  transition: color 0.3s ease;
}

.branding h1:hover span {
  color: #ffb347;
}

.branding p {
  color: #2bbeff;
  font-size: 14px;
  font-weight: 600;
  margin-top: 0;
  letter-spacing: 0.2em;
  transition: letter-spacing 0.3s ease;
}

.branding p:hover {
  letter-spacing: 0.3em;
}

/* RIGHT PANEL */
.right-panel {
  background: linear-gradient(to bottom, #0f1e3a 0%, #1b3c5b 50%, #29476b 100%);
  flex: 1;
  /* border-radius: 30px 0 0 30px; */
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  overflow: hidden;
  animation: slideInRight 1s ease-out;
}

/* Login form */
.login-form {
  width: min(600px, 90vw);
  background: rgba(22, 74, 110, 0.85);
  border-radius: 25px;
  padding: clamp(30px, 20vw, 42px) clamp(20px, 5vw, 36px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.95);
  display: flex;
  flex-direction: column;
  color: white;
  user-select: none;
  z-index: 2;
  animation: fadeInUp 1s ease-out 0.7s both;
  transition: transform 0.3s ease;
}

.login-form:hover {
  transform: translateY(-5px);
}

/* Title with lock icon */
.title {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 22px;
  font-weight: 600;
  margin-bottom: 4px;
  line-height: 1.1;
  transition: transform 0.3s ease;
  flex-wrap: wrap;
  justify-content: center;
}

.title:hover {
  transform: translateY(-2px);
}

.lock-icon {
  width: 80px;
  height: 80px;
  user-select: none;
  transition: transform 0.3s ease;
  flex-shrink: 0;
}

.title:hover .lock-icon {
  transform: rotate(10deg);
}

/* Subtitle */
.subtitle {
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 10px;
  color: #cddde6cc;
  transition: opacity 0.3s ease;
}

.subtitle:hover {
  opacity: 0.8;
}

/* Labels */
.input-label {
  font-size: 12px;
  font-style: italic;
  font-weight: 400;
  margin-bottom: 8px;
  color: #b6c7db;
  user-select: none;
  transition: color 0.3s ease;
}

.input-label:hover {
  color: #ffffff;
}

/* Text inputs */
.input-field {
  width: 100%;
  height: 38px;
  border-radius: 6px;
  border: 2px solid transparent;
  padding: 0 14px;
  font-size: 14px;
  margin-bottom: 24px;
  outline: none;
  user-select: text;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
}

.input-field:focus {
  border-color: #08a3f9;
  box-shadow: 0 0 8px rgba(8, 163, 249, 0.5);
  transform: scale(1.02);
}

.input-field::placeholder {
  color: #b6c7db;
  transition: color 0.3s ease;
}

.input-field:focus::placeholder {
  color: #ffffff;
}

/* Sign in button */
.sign-in-btn {
  width: 100%;
  height: 38px;
  background: #08a3f9;
  font-weight: 600;
  font-size: 14px;
  border: none;
  border-radius: 18px;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
  user-select: none;
  position: relative;
  overflow: hidden;
}

.sign-in-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s ease;
}

.sign-in-btn:hover::before {
  left: 100%;
}

.sign-in-btn:hover {
  background: #068fd4;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(8, 163, 249, 0.4);
}

.sign-in-btn:active {
  transform: translateY(0);
}

/* Particle canvas positioning */
#particle-canvas {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
}

/* Keyframe animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideInLeft {
  from { transform: translateX(-100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInRight {
  from { transform: translateX(100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@keyframes slideInUp {
  from { transform: translateY(50px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeInUp {
  from { transform: translateY(30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}

@keyframes pulse {
  0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
  50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
}

/* Responsive Design */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
    height: 100vh;
  }

  .left-panel, .right-panel {
    width: 100%;
  }

  .left-panel {
    height: 60vh;
    padding: 20px;
    justify-content: space-between;
    text-align: center;
    flex-direction: column;
    order: 1;
  }

  .right-panel {
    height: 40vh;
    padding: 20px;
    order: 2;
  }

  .circle-image-wrapper {
    width: min(250px, 60vw);
    height: min(250px, 60vw);
  }

  .glow-ring {
    width: min(250px, 60vw);
    height: min(250px, 60vw);
  }

  .center-image {
    width: calc(100% - 50px);
    height: calc(100% - 50px);
  }

  .branding {
    margin-top: 20px;
  }

  .branding h1 {
    font-size: 28px;
  }

  .logo {
    font-size: 20px;
    justify-content: center;
  }

  .login-form {
    width: 90%;
    max-width: 360px;
    margin: 0 auto;
  }

  .title {
    font-size: 18px;
    gap: 4px;
  }

  .lock-icon {
    width: 60px;
    height: 60px;
  }

  .subtitle {
    font-size: 12px;
  }

  .input-field, .sign-in-btn {
    height: 40px;
    font-size: 16px;
  }

  .input-label {
    font-size: 11px;
  }
}

@media (max-width: 480px) {
  .circle-image-wrapper {
    width: min(200px, 50vw);
    height: min(200px, 50vw);
  }

  .glow-ring {
    width: min(200px, 50vw);
    height: min(200px, 50vw);
  }

  .center-image {
    width: calc(100% - 50px);
    height: calc(100% - 50px);
  }

  .branding h1 {
    font-size: 24px;
  }

  .login-form {
    width: 95%;
    padding: 30px 20px;
  }

  .title {
    font-size: 16px;
  }

  .lock-icon {
    width: 50px;
    height: 50px;
  }
}

</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const canvas = document.getElementById('particle-canvas');
  const ctx = canvas.getContext('2d');
  const particles = [];
  const particleCount = 150;
  const maxDistance = 100;

  function resizeCanvas() {
    canvas.width = canvas.parentElement.offsetWidth;
    canvas.height = canvas.parentElement.offsetHeight;
  }

  function createParticles() {
    for (let i = 0; i < particleCount; i++) {
      particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        vx: (Math.random() - 0.5) * 0.5,
        vy: (Math.random() - 0.5) * 0.5,
        size: Math.random() * 2 + 1,
        // color: 'rgba(255, 255, 255, 0.7)'
        color : '#113F67'
      });
    }
  }

  function updateParticles() {
    particles.forEach(particle => {
      particle.x += particle.vx;
      particle.y += particle.vy;

      if (particle.x < 0 || particle.x > canvas.width) particle.vx *= -1;
      if (particle.y < 0 || particle.y > canvas.height) particle.vy *= -1;
    });
  }

  function drawParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach(particle => {
      ctx.beginPath();
      ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
      ctx.fillStyle = particle.color;
      ctx.fill();
    });

    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < maxDistance) {
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.strokeStyle = `rgba(255, 255, 255, ${1 - distance / maxDistance})`;
          ctx.lineWidth = 0.5;
          ctx.stroke();
        }
      }
    }
  }

  function animate() {
    updateParticles();
    drawParticles();
    requestAnimationFrame(animate);
  }

  resizeCanvas();
  createParticles();
  animate();

  window.addEventListener('resize', resizeCanvas);
});
</script>

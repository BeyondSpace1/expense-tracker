tsParticles.load("tsparticles", {
  background: {
    color: { value: "transparent" }
  },
  fpsLimit: 60,
  particles: {
    number: {
      value: 25,
      density: { enable: true, area: 800 }
    },
    color: { value: "#3b82f6" },
    shape: { type: "circle" },
    size: { value: 4 },
    opacity: { value: 0.8 },
    move: {
      enable: true,
      speed: 1.2,
      random: true,
      direction: "none",
      outModes: { default: "bounce" }
    },
    links: {
      enable: true,
      distance: 120,
      color: "#3b82f6",
      opacity: 0.4,
      width: 2
    }
  },
  interactivity: {
    events: {
      onhover: { enable: true, mode: "repulse" },
      onclick: { enable: true, mode: "push" },
      resize: true
    },
    modes: {
      repulse: { distance: 150, duration: 0.4 },
      push: { quantity: 1 }
    }
  },
  detectRetina: true
});
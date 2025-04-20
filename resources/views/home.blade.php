<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Get Started | Modern Landing Page</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary: #4a89dc;
      --primary-light: #5d9cec;
      --primary-dark: #3b7dd8;
      --accent: #48cfad;
      --text: #434a54;
      --light: #f5f7fa;
      --white: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: var(--light);
      color: var(--text);
      line-height: 1.6;
    }

    header {
      background: var(--primary);
      color: white;
      padding: 1.2rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      animation: slideDown 0.6s ease-out;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header h2 {
      font-size: 1.5rem;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin-left: 1.5rem;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: var(--accent);
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .container {
      max-width: 1200px;
      padding: 3rem 2rem;
      margin: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      animation: fadeIn 1s ease;
    }

    .logo {
      width: 60px;
      height: 60px;
      background-color: var(--primary);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 10px 20px rgba(74, 137, 220, 0.2);
    }

    h1 {
      font-size: 3.5rem;
      margin-bottom: 1.5rem;
      color: var(--primary-dark);
      font-weight: 700;
      line-height: 1.2;
    }

    .highlight {
      color: var(--accent);
      position: relative;
      display: inline-block;
    }

    .highlight::after {
      content: '';
      position: absolute;
      bottom: 8px;
      left: 0;
      width: 100%;
      height: 12px;
      background-color: rgba(72, 207, 173, 0.3);
      z-index: -1;
      border-radius: 4px;
    }

    p {
      font-size: 1.25rem;
      margin-bottom: 3rem;
      max-width: 700px;
      font-weight: 400;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background-color: var(--primary);
      color: var(--white);
      padding: 1.25rem 3rem;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(74, 137, 220, 0.3);
      position: relative;
      overflow: hidden;
      border: none;
      cursor: pointer;
    }

    .btn:hover {
      background-color: var(--primary-light);
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(74, 137, 220, 0.4);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .illustration {
      width: 100%;
      max-width: 600px;
      margin-top: 4rem;
      filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.1));
    }

    section {
      padding: 4rem 2rem;
      background-color: var(--white);
      text-align: center;
      animation: fadeIn 1.2s ease;
    }

    section h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: var(--primary-dark);
    }

    section p {
      max-width: 800px;
      margin: auto;
      font-size: 1.2rem;
    }

    .services {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2rem;
      margin-top: 2.5rem;
    }

    .service-card {
      background: var(--light);
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      padding: 2rem;
      width: 280px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .service-card h3 {
      color: var(--primary);
      font-size: 1.4rem;
      margin-bottom: 0.8rem;
    }

    .service-card p {
      font-size: 1rem;
      color: var(--text);
    }

    footer {
      background-color: var(--primary);
      color: white;
      text-align: center;
      padding: 2rem 1rem;
      margin-top: 4rem;
      animation: fadeInUp 1s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2.5rem;
      }

      p {
        font-size: 1.1rem;
      }

      .btn {
        padding: 1rem 2.5rem;
      }

      .services {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <header>
    <h2>SmartExam</h2>
    <nav>
      <a href="#">Home</a>
      <a href="#about">About</a>
      <a href="#services">Services</a>
      <a href="#contact">Contact</a>
    </nav>
  </header>

  <div class="container">
    <div class="logo">Hey</div>
    <h1>Are you ready to <span class="highlight">Start</span>?</h1>
    <p>Click the button to begin your exam with us.</p>
    <a href="{{ route("auth.index") }}" class="btn">Get Started</a>
    <img src="https://illustrations.popsy.co/amber/digital-nomad.svg" alt="Illustration" class="illustration" />
  </div>

  <section id="about">
    <h2>About Us</h2>
    <p>
      We are committed to delivering an intuitive and secure online examination experience.
      Our platform is designed to simplify the way students, teachers, and institutions manage tests and results.
    </p>
  </section>

  <section id="services">
    <h2>Our Services</h2>
    <div class="services">
      <div class="service-card">
        <h3>Online Exams</h3>
        <p>Conduct secure and reliable exams with real-time monitoring and automatic grading.</p>
      </div>
      <div class="service-card">
        <h3>Student Portal</h3>
        <p>Easy-to-use dashboard for students to view schedules, results, and feedback.</p>
      </div>
      <div class="service-card">
        <h3>Teacher Tools</h3>
        <p>Quiz creation, performance analytics, and student progress tracking made simple.</p>
      </div>
    </div>
  </section>

  <footer id="contact">
    &copy; 2025 SmartExam. All rights reserved.
  </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Providing the best medical care with state-of-the-art equipment and experienced professionals.">
    <meta name="author" content="Medical Care">
    <title>Medical Care</title>
    @vite('resources/css/app.css')
</head>
<body>
<div class="min-h-screen bg-gray-100">
    <!-- Header Section -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-primary-500">Medical Care</h1>
            <nav class="flex space-x-4">
                <a href="#about" class="hover:text-primary-500 text-gray-700">About</a>
                <a href="#services" class="hover:text-primary-500 text-gray-700">Services</a>
                <a href="#contact" class="hover:text-primary-500 text-gray-700">Contact Us</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-primary-50 py-16 animate-fade-in">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-extrabold text-primary-600 leading-tight">
                Your Health, Our Priority
            </h2>
            <p class="mt-4 text-lg text-gray-700">
                Providing the best medical care with state-of-the-art equipment and experienced professionals.
            </p>
            <div class="mt-6">
                <a href="#services"
                   class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg shadow hover:bg-primary-500">
                    Explore Our Services
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white animate-slide-in">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h3 class="text-3xl font-bold text-gray-800">About Us</h3>
                <p class="mt-4 text-gray-600">
                    We are a dedicated team of medical professionals focused on delivering top-notch healthcare
                    solutions.
                </p>
            </div>
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <img src="https://via.placeholder.com/600x400" alt="Healthcare professionals"
                     class="rounded-lg shadow-md">
                <div class="flex flex-col justify-center">
                    <p class="text-gray-700">
                        Our expertise spans various medical fields, offering comprehensive services to cater to every
                        patient’s need. With a focus on cutting-edge technology and compassionate care, we’re here to
                        support your wellbeing.
                    </p>
                    <a href="#" class="mt-4 text-primary-600 font-medium hover:underline">
                        Learn More About Us →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-16 bg-gray-50 animate-fade-in-up">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-gray-800">Our Services</h3>
            <p class="mt-4 text-gray-600">
                Discover the wide range of services we provide to meet your medical needs.
            </p>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 shadow rounded-lg">
                    <h4 class="font-bold text-primary-600">General Checkup</h4>
                    <p class="mt-2 text-gray-600">
                        Comprehensive health evaluations to keep you healthy and informed.
                    </p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h4 class="font-bold text-primary-600">Dental Care</h4>
                    <p class="mt-2 text-gray-600">
                        High-quality dental services to ensure your brightest smile.
                    </p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg">
                    <h4 class="font-bold text-primary-600">Emergency Services</h4>
                    <p class="mt-2 text-gray-600">
                        24/7 emergency care to assist you when you need it the most.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-16 bg-white animate-slide-in">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-gray-800">What Our Patients Say</h3>
            <p class="mt-4 text-gray-600">See what our happy patients have to say about our services.</p>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-primary-50 p-6 shadow rounded-lg">
                    <p class="italic text-gray-600">
                        "I received excellent care from the team! The staff were incredibly supportive."
                    </p>
                    <h4 class="mt-4 font-bold text-primary-600">- John Doe</h4>
                </div>
                <div class="bg-primary-50 p-6 shadow rounded-lg">
                    <p class="italic text-gray-600">
                        "The facilities are top-notch and the doctors truly care about your well-being."
                    </p>
                    <h4 class="mt-4 font-bold text-primary-600">- Jane Smith</h4>
                </div>
                <div class="bg-primary-50 p-6 shadow rounded-lg">
                    <p class="italic text-gray-600">
                        "Amazing service! They were there for me in an emergency situation, and I’m so grateful."
                    </p>
                    <h4 class="mt-4 font-bold text-primary-600">- Robert Brown</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-gray-800">Contact Us</h3>
            <p class="mt-4 text-gray-600">
                Reach out to us with any questions or to schedule an appointment.
            </p>
            <form action="#" method="POST" class="mt-8 max-w-xl mx-auto space-y-4 animate-fade-in">
                <input type="text" name="name" placeholder="Your Name"
                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                <input type="email" name="email" placeholder="Your Email"
                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                <textarea name="message" rows="4" placeholder="Your Message"
                          class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500"></textarea>
                <button type="submit"
                        class="w-full px-6 py-3 bg-primary-600 text-white font-medium rounded-lg shadow hover:bg-primary-500">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-6 text-gray-300">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Medical Care. All rights reserved.</p>
        </div>
    </footer>
</div>
</body>
</html>

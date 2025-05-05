<footer class="bg-blue-900 text-white py-12 sticky-bottom">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informasi -->
        <div>
            <h2 class="text-2xl font-semibold mb-2">{{ $company->name }}</h2>
            <p class="text-sm text-gray-300 mb-6">
                {{ $company->email }}
            </p>

            <div class="mb-4 flex items-start space-x-2">
                <i class="fa-brands fa-whatsapp text-xl mt-1"></i>
                <div>
                    <p class="font-medium">Whatsapp:</p>
                    <p class="text-gray-300">{{ $company->phone }}</p>
                </div>
            </div>

            <div class="flex items-start space-x-2">
                <i class="fa-solid fa-location-dot text-xl mt-1"></i>
                <div>
                    <p class="font-medium">Alamat:</p>
                    <p class="text-gray-300">
                        {{ $company->address }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Peta dan App -->
        <div class="flex flex-col items-start md:items-end space-y-4">
            <!-- Google Map Embed -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.197038360573!2d103.9633564!3d1.072426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da4e8b8703e257%3A0x5473ab2f39dc45d1!2sYayasan%20Darussalam%20Batam!5e0!3m2!1sen!2sid!4v1714551600000!5m2!1sen!2sid"
                width="300"
                height="150"
                class="rounded-md border-0 shadow-md"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>

            <!-- Google Play Badge -->
            <a href="#" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                     alt="Google Play"
                     class="h-12 mt-2">
            </a>
        </div>
    </div>

    <!-- Bawah Footer -->
    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-400">
        <p>{{ $company->name }} © 2025 All rights Reserved.</p>
        <div class="mt-4 flex justify-center space-x-6 text-white text-lg">
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</footer>

<!-- Font Awesome CDN (jika belum ada) -->
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>

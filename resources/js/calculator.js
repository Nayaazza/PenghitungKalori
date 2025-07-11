import $ from "jquery";

export function initCalculator() {
    const calculatorContainer = $("#calculator-container");
    if (calculatorContainer.length) {
        const calculateUrl = calculatorContainer.data("calculate-url");
        const loadingContent = `<div class="text-center text-gray-500 animate-fade-in"><div class="w-12 h-12 border-4 border-orange-400 border-t-transparent rounded-full animate-spin mx-auto"></div><p class="mt-4 font-semibold">Menghitung...</p></div>`;

        function getResultContent(response) {
            return `<div class="text-center animate-fade-in"><p class="text-xl text-gray-600">Anda telah membakar sekitar</p><h1 class="text-7xl font-bold text-orange-500 my-2">${response.calories_burned}</h1><p class="text-xl text-gray-600 mb-3">Kalori!</p><p class="text-sm text-gray-500">Berdasarkan olahraga ${response.sport_name} selama ${response.duration} menit dengan berat badan ${response.weight} kg.</p></div>`;
        }
        function getErrorContent(message) {
            return `<div class="text-center text-red-600 font-medium animate-fade-in">${message}</div>`;
        }

        $("#sport_id").on("change", function () {
            const selectedOption = $(this).find("option:selected");
            const iconSvgPath = selectedOption.data("icon-svg"); // Ambil path SVG dari data attribute
            const sportIcon = $("#sport-icon");

            if (iconSvgPath) {
                // Ganti isi dari elemen SVG dengan path yang baru
                sportIcon.html(iconSvgPath);

                // Ubah juga warnanya untuk memberikan feedback
                $("#sport-icon-container")
                    .removeClass("bg-gray-100")
                    .addClass("bg-orange-100");
                sportIcon
                    .removeClass("text-gray-400")
                    .addClass("text-orange-500");
            }
        });

        $("#calculate-form").on("submit", function (e) {
            e.preventDefault();
            const resultViewport = $("#result-viewport");
            resultViewport.html(loadingContent);
            $.ajax({
                url: calculateUrl,
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    resultViewport.html(getResultContent(response));
                },
                error: function (xhr) {
                    const errorMessage =
                        xhr.responseJSON && xhr.responseJSON.error
                            ? xhr.responseJSON.error
                            : "Terjadi kesalahan.";
                    resultViewport.html(getErrorContent(errorMessage));
                },
            });
        });

        $("<style>")
            .text(
                `@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } } .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }`
            )
            .appendTo("head");
    }
}

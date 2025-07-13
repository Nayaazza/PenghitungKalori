import $ from "jquery";

export function initCalculator() {
    const calculatorContainer = $("#calculator-container");
    if (!calculatorContainer.length) {
        return;
    }

    const calculateUrl = calculatorContainer.data("calculate-url");
    const resultViewport = $("#result-viewport");
    const sportImage = $("#sport-image");

    const loadingContent = `<div class="text-center text-gray-500"><div class="w-12 h-12 border-4 border-orange-400 border-t-transparent rounded-full animate-spin mx-auto"></div><p class="mt-4 font-semibold">Menghitung...</p></div>`;

    function getResultContent(response) {
        return `<div class="text-center">
                    <p class="text-xl text-gray-600">Anda telah membakar sekitar</p>
                    <h1 class="text-6xl md:text-7xl font-bold text-orange-500 my-2">${response.calories_burned}</h1>
                    <p class="text-xl text-gray-600 mb-3">Kalori!</p>
                    <p class="text-sm text-gray-500">Berdasarkan olahraga ${response.sport_name} selama ${response.duration} menit dengan berat badan ${response.weight} kg.</p>
                </div>`;
    }

    function getErrorContent(message) {
        return `<div class="text-center text-red-600 font-medium">${message}</div>`;
    }

    $("#sport_id").on("change", function () {
        const selectedOption = $(this).find("option:selected");
        const imageUrl = selectedOption.data("image-url");
        if (imageUrl) {
            sportImage.attr("src", imageUrl);
            $("#sport-image-container")
                .removeClass("bg-gray-100")
                .addClass("bg-orange-50");
        }
    });

    // --- LOGIKA UNTUK TOMBOL PINTASAN WAKTU ---
    $(".quick-time-btn").on("click", function () {
        const preset = $(this).data("time-preset");
        let targetDate = new Date();

        switch (preset) {
            case "now":
                break;
            case "yesterday":
                targetDate.setDate(targetDate.getDate() - 1);
                break;
            case "morning":
                targetDate.setHours(8, 0, 0, 0); // Setel ke jam 8 pagi ini
                break;
        }

        // Format tanggal ke YYYY-MM-DDTHH:mm yang dibutuhkan oleh input
        const year = targetDate.getFullYear();
        const month = String(targetDate.getMonth() + 1).padStart(2, "0");
        const day = String(targetDate.getDate()).padStart(2, "0");
        const hours = String(targetDate.getHours()).padStart(2, "0");
        const minutes = String(targetDate.getMinutes()).padStart(2, "0");
        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

        $("#activity_time").val(formattedDateTime);
    });

    $("#calculate-form").on("submit", function (e) {
        e.preventDefault();
        resultViewport.html(loadingContent);

        $.ajax({
            url: calculateUrl,
            method: "POST",
            data: $(this).serialize(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                resultViewport.html(getResultContent(response));
            },
            error: function (xhr) {
                const errorMessage =
                    xhr.responseJSON?.error ||
                    "Terjadi kesalahan. Pastikan semua kolom terisi.";
                resultViewport.html(getErrorContent(errorMessage));
            },
        });
    });
}

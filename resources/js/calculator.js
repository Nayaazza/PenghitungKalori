import $ from "jquery";

export function initCalculator() {
    const calculatorContainer = $("#calculator-container");
    if (!calculatorContainer.length) {
        return; // Keluar jika ini bukan halaman kalkulator
    }

    const calculateUrl = calculatorContainer.data("calculate-url");
    const resultViewport = $("#result-viewport");
    const sportImage = $("#sport-image");

    // --- FUNGSI UNTUK MENAMPILKAN HASIL ---
    const loadingContent = `<div class="text-center text-gray-500"><div class="w-12 h-12 border-4 border-orange-400 border-t-transparent rounded-full animate-spin mx-auto"></div><p class="mt-4 font-semibold">Menghitung...</p></div>`;

    function showResult(htmlContent) {
        resultViewport.html(htmlContent);
    }

    function getResultContent(response) {
        return `<div class="text-center"><p class="text-xl text-gray-600">Anda telah membakar sekitar</p><h1 class="text-7xl font-bold text-orange-500 my-2">${response.calories_burned}</h1><p class="text-xl text-gray-600 mb-3">Kalori!</p><p class="text-sm text-gray-500">Berdasarkan olahraga ${response.sport_name} selama ${response.duration} menit dengan berat badan ${response.weight} kg.</p></div>`;
    }

    function getErrorContent(message) {
        return `<div class="text-center text-red-600 font-medium">${message}</div>`;
    }

    // --- EVENT LISTENER UNTUK DROPDOWN OLAHRAGA ---
    $("#sport_id").on("change", function () {
        const selectedOption = $(this).find("option:selected");
        const imageUrl = selectedOption.data("image-url");

        // **DEBUGGING**: Tampilkan URL di console browser (Tekan F12 untuk melihat)
        console.log("Mencoba memuat gambar dari:", imageUrl);

        if (imageUrl) {
            sportImage.attr("src", imageUrl);
            $("#sport-image-container")
                .removeClass("bg-gray-100")
                .addClass("bg-orange-50");
        } else {
            console.error(
                "URL gambar tidak ditemukan untuk opsi yang dipilih."
            );
        }
    });

    // --- EVENT LISTENER UNTUK SUBMIT FORM ---
    $("#calculate-form").on("submit", function (e) {
        e.preventDefault();
        showResult(loadingContent);

        $.ajax({
            url: calculateUrl,
            method: "POST",
            data: $(this).serialize(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                showResult(getResultContent(response));
            },
            error: function (xhr) {
                const errorMessage =
                    xhr.responseJSON?.error ||
                    "Terjadi kesalahan. Pastikan semua kolom terisi.";
                showResult(getErrorContent(errorMessage));
            },
        });
    });
}

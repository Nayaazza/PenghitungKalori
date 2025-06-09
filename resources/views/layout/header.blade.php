<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penghitung Kalori Olahraga</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container">
    <h1>Penghitung Kalori Olahraga</h1>

    <label for="exercise">Pilih Olahraga:</label>
    <select id="exercise">
      <option value="">--Pilih--</option>
      <option value="lari">Lari</option>
      <option value="bersepeda">Bersepeda</option>
      <option value="berenang">Berenang</option>
      <option value="yoga">Yoga</option>
    </select>

    <label for="duration">Durasi (menit):</label>
    <input type="number" id="duration" min="1" placeholder="Masukkan durasi">

    <button onclick="hitungKalori()">Hitung Kalori</button>
    <button onclick="resetForm()">Reset</button>

    <div id="result"></div>
  </div>

  <script src="script.js"></script>
</body>
</html>

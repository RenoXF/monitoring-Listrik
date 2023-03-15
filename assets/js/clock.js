function updateClock() {
    const now = new Date();
    let jam = now.getHours();
    let menit = now.getMinutes();
    let detik = now.getSeconds();
    jam = jam < 10 ? '0' + jam : jam;
    menit = menit < 10 ? '0' + menit : menit;
    detik = detik < 10 ? '0' + detik : detik;
    const waktu = jam + ':' + menit + ':' + detik;
    document.getElementById('time').innerHTML = waktu;
    setInterval(updateClock, 1000);
}

updateClock()

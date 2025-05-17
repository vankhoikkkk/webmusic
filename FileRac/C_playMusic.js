
    // sử lý cho phần hiện thanh nhạc khi bấm vào
    const audioPlayer = document.getElementById('audio');
    const songCards = document.querySelectorAll('.song-card');
    const imgScrThanhNhac = document.querySelector('.cover > img');
    const containerPlay = document.querySelector('.container-play');

    const playButtonCard = document.querySelector('.play-overlay');

    // sử lý riêng cho thanh nhạc
    const audio = document.getElementById("audio");
    const playButton = document.getElementById("play");
    const duration = document.getElementById("duration");
    const current = document.getElementById("current");
    const progress = document.getElementById("progress");
    const volume = document.getElementById("volume");
    const volumeIcon = document.getElementById("volume-icon");


    let currentAudioSrc = '';
    let currentTime = 0;
    let currentCard = null; // Thêm biến để theo dõi card hiện tại

    songCards.forEach(card => {
        card.addEventListener('click', () => {
            const audioSrc = card.getAttribute('data-audio');
            const currentImg = card.querySelector('img');
            const playButtonCard = card.querySelector('.play-overlay i');

            const songTitle = card.querySelector(".baihat").textContent; // Lấy text từ thẻ p
            const songTitle2 = card.querySelector(".casi").textContent; 
            // Cập nhật tên bài hát trong thanh nhạc
            document.getElementById('song-name').textContent = songTitle;   
            document.getElementById('artist-name').textContent = songTitle2;   

            // Nếu click vào card khác
            if (currentCard && currentCard !== card) {
                // Reset card cũ
                const oldPlayButton = currentCard.querySelector('.play-overlay i');
                oldPlayButton.className = 'bx bx-play-circle';
                // Reset thời gian của bài cũ
                currentTime = 0;
            }

            // Cập nhật card hiện tại
            currentCard = card;

            // hiện thanh nhạc
            containerPlay.classList.add('show');

            // hiện ảnh bài hát
            imgScrThanhNhac.src = currentImg.src;

            if (audioPlayer.src.includes(audioSrc)) {
                if (audioPlayer.paused) {
                    audioPlayer.play();
                    // hiện ảnh bật pause
                    playButtonCard.className = 'bx bx-pause-circle'; // thay đổi toàn bộ class có trong thẻ thanh 1 class này
                    playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
                } else {
                    audioPlayer.pause();
                    // hiện ảnh bật play
                    playButtonCard.className = 'bx bx-play-circle';
                    playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
                }
            } else {
                // Khi chọn bài mới
                currentAudioSrc = audioSrc;
                audioPlayer.src = audioSrc;
                audioPlayer.currentTime = 0; // Reset thời gian về 0
                audioPlayer.play();

                // Cập nhật tất cả icon về play
                document.querySelectorAll('.play-overlay i').forEach(icon => {
                    icon.className = 'bx bx-play-circle';
                });

                // Cập nhật icon play/pause cho bài hiện tại
                playButtonCard.className = 'bx bx-pause-circle';
                playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
            }
        });
    });

    // Cập nhật event listener của playButton
    playButton.addEventListener('click', function() {
        if (!currentCard) return; // Nếu chưa có card nào được chọn

        const playButtonCard = currentCard.querySelector('.play-overlay i');

        if (audio.paused) {
            audio.play();
            playButtonCard.className = 'bx bx-pause-circle';
            playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
        } else {
            audio.pause();
            playButtonCard.className = 'bx bx-play-circle';
            playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
        }
    });

    // Cập nhật event listener của audio
    audioPlayer.addEventListener('ended', () => {
        // Khi bài hát kết thúc
        if (currentCard) {
            const playButtonCard = currentCard.querySelector('.play-overlay i');
            playButtonCard.className = 'bx bx-play-circle';
            playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
            currentTime = 0;
        }
    });

    // Lưu thời gian hiện tại khi tạm dừng
    audioPlayer.addEventListener('pause', () => {
        currentTime = audioPlayer.currentTime;
    });

    // Khôi phục thời gian khi play lại
    audioPlayer.addEventListener('play', () => {
        if (currentTime > 0) {
            audioPlayer.currentTime = currentTime;
        }
    });


    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secon = Math.floor(seconds % 60);
        return `${minutes < 10 ? '0' + minutes : minutes}:${secon < 10 ? '0' + secon : secon}`;
    };


    audio.addEventListener('loadedmetadata', function() {
        duration.textContent = formatTime(audio.duration);
        // console.log(formatTime(audio.duration));
    });

    audio.addEventListener('timeupdate', function() {
        current.textContent = formatTime(audio.currentTime);
        progress.value = (audio.currentTime / audio.duration) * 100;
    });

    progress.addEventListener("input", () => {
        audio.currentTime = (progress.value / 100) * audio.duration;
    })
    // giá trị của thanh âm lượng 0.0 - 1.0
    volume.addEventListener("input", function() {
        audio.volume = volume.value;
    });



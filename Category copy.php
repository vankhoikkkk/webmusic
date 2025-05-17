<?php
session_start();

// Khởi tạo session history nếu chưa tồn tại
if (!isset($_SESSION['music_history'])) {
  $_SESSION['music_history'] = [];
}

// Xử lý AJAX request để cập nhật history
if (isset($_POST['add_to_history'])) {
  $songData = [
    'id' => $_POST['id'],
    'title' => $_POST['title'],
    'artist' => $_POST['artist'],
    'cover' => $_POST['cover'],
    'audio' => $_POST['audio'],
    'timestamp' => time()
  ];

  // Kiểm tra xem bài hát đã có trong history chưa
  $exists = false;
  foreach ($_SESSION['music_history'] as $key => $song) {
    if ($song['id'] === $songData['id']) {
      // Nếu đã tồn tại, cập nhật timestamp
      $_SESSION['music_history'][$key]['timestamp'] = time();
      $exists = true;
      break;
    }
  }

  // Nếu chưa tồn tại, thêm vào history
  if (!$exists) {
    // Giới hạn 10 bài gần nhất
    if (count($_SESSION['music_history']) >= 10) {
      array_pop($_SESSION['music_history']);
    }
    array_unshift($_SESSION['music_history'], $songData);
  }

  exit;
}

include 'DAO/CategoryDAO.php';
?>


<?php

$listMusic = new CategoryDAO();
$result_tre = $listMusic->getAllMusicOfGengerTOP('Nhạc Trẻ');
$result_Rap = $listMusic->getAllMusicOfGengerTOP('Nhạc Rap');
$result_Au = $listMusic->getAllMusicOfGengerTOP('Nhạc Âu');
$result_Trung = $listMusic->getAllMusicOfGengerTOP('Nhạc Trung');
$result_Do = $listMusic->getAllMusicOfGengerTOP('Nhạc Đỏ');

?>
<style>

  /* ------------ lưu lịch sử nghe nhạc------------- */
  .recently-played {
    padding: 20px;
    margin-top: 20px;
    background: rgba(35, 35, 35, 0.8);
    border-radius: 10px;
    padding-bottom: 100px;
  }

  .recently-played h3 {
    color: #fff;
    margin-bottom: 15px;
  }

  .history-songs {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    padding: 10px 0;
  }

  .history-songs .song-card {
    min-width: 200px;
  }

  /* Tùy chỉnh thanh cuộn */
  .history-songs::-webkit-scrollbar {
    height: 8px;
  }

  .history-songs::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
  }

  .history-songs::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
  }
</style>




<?php include 'V_headerCategory.php' ?>

<!----------------------------------- danh sách nhạc --------------------------------------------->

<div class="container-list-hot">

  <!-- NHẠC TRẺ VIỆT NAM -->
  <div class="list-music-top">
    <div class="hot-title">🎧 Top Nhạc Trẻ</div>
    <div class="hot-songs">
      <?php
      if ($result_tre) {
        while ($row = $result_tre->fetch_assoc()) {
      ?>
          <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
            <div class="play-overlay">
              <i class='bx bx-play-circle'></i>
            </div>
            <img src="<?php echo $row['album']; ?>" alt="Song">
            <div class="song-info">
              <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
              <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>Không có bài hát nào.</p>";
      }
      ?>
    </div>
  </div>

  <!-- NHẠC RAP VIỆT -->
  <div class="list-music-top">
    <div class="hot-title"><i class='bx bxl-unity'></i> Top Nhạc Rap</div>
    <div class="hot-songs">
      <?php
      if ($result_Rap) {
        while ($row = $result_Rap->fetch_assoc()) {
      ?>
          <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
            <div class="play-overlay">
              <i class='bx bx-play-circle'></i>
            </div>
            <img src="<?php echo $row['album']; ?>" alt="Song">
            <div class="song-info">
              <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
              <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>Không có bài hát nào.</p>";
      }
      ?>
    </div>
  </div>

  <!-- NHẠC ÂU -->
  <div class="list-music-top">
    <div class="hot-title">🎧 Top Nhạc Âu</div>
    <div class="hot-songs">
      <?php
      if ($result_Au) {
        while ($row = $result_Au->fetch_assoc()) {
      ?>
          <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
            <div class="play-overlay">
              <i class='bx bx-play-circle'></i>
            </div>
            <img src="<?php echo $row['album']; ?>" alt="Song">
            <div class="song-info">
              <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
              <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>Không có bài hát nào.</p>";
      }
      ?>
    </div>
  </div>

  <!-- NHẠC TRUNG QUỐC -->
  <div class="list-music-top">
    <div class="hot-title">🎧 Top Nhạc Trung</div>
    <div class="hot-songs">
      <?php
      if ($result_Trung) {
        while ($row = $result_Trung->fetch_assoc()) {
      ?>
          <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
            <div class="play-overlay">
              <i class='bx bx-play-circle'></i>
            </div>
            <img src="<?php echo $row['album']; ?>" alt="Song">
            <div class="song-info">
              <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
              <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>Không có bài hát nào.</p>";
      }
      ?>
    </div>
  </div>
  <!-- NHẠC ĐỎ VIỆT NAM -->
  <div class="list-music-top">
    <div class="hot-title">🎧 Top Nhạc Đỏ</div>
    <div class="hot-songs">
      <?php
      if ($result_Do) {
        while ($row = $result_Do->fetch_assoc()) {
      ?>
          <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>" data-id="<?php echo $row['id_baihat']; ?>">
            <div class="play-overlay">
              <i class='bx bx-play-circle'></i>
            </div>
            <img src="<?php echo $row['album']; ?>" alt="Song">
            <div class="song-info">
              <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
              <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p>Không có bài hát nào.</p>";
      }
      ?>
    </div>
  </div>

</div>

<?php include 'player.php' ?>

<div class="recently-played">
  <h3>Bài hát đã phát gần đây</h3>
  <div class="history-songs">
    <?php
    if (!empty($_SESSION['music_history'])) {
      foreach ($_SESSION['music_history'] as $song) {
    ?>
        <div class="song-card" data-audio="<?php echo $song['audio']; ?>" data-id="<?php echo $song['id']; ?>">
          <div class="play-overlay">
            <i class='bx bx-play-circle'></i>
          </div>
          <img src="<?php echo $song['cover']; ?>" alt="Song">
          <div class="song-info">
            <p class="baihat"><?php echo $song['title']; ?></p>
            <p class="casi">(<?php echo $song['artist']; ?>)</p>
          </div>
        </div>
    <?php
      }
    } else {
      echo "<p>Chưa có bài hát nào được phát</p>";
    }
    ?>
  </div>
</div>

</body>

<script>
  // Khai báo biến
  const audioPlayer = document.getElementById('audio');
  const songCards = document.querySelectorAll('.song-card');
  const imgScrThanhNhac = document.querySelector('.cover > img');
  const containerPlay = document.querySelector('.container-play');
  const playButton = document.getElementById("play");
  const duration = document.getElementById("duration");
  const current = document.getElementById("current");
  const progress = document.getElementById("progress");
  const volume = document.getElementById("volume");
  const volumeIcon = document.getElementById("volume-icon");

  let currentAudioSrc = '';
  let currentTime = 0;
  let currentCard = null;
  let currentIndex = 0;

  // Thêm vào sau phần khai báo biến
  function updatePlayHistory(card) {
    const data = new FormData();
    data.append('add_to_history', '1');
    data.append('id', card.getAttribute('data-id'));
    data.append('title', card.querySelector('.baihat').textContent);
    data.append('artist', card.querySelector('.casi').textContent);
    data.append('cover', card.querySelector('img').src);
    data.append('audio', card.getAttribute('data-audio'));

    fetch(window.location.href, {
      method: 'POST',
      body: data
    });
  }

  // Hàm phát nhạc chính
  function playMusic(card) {
    console.log(card);
    // Xóa class playing từ tất cả card 
    document.querySelectorAll('.song-card').forEach(c => {
      c.classList.remove('playing');
    });

    const audioSrc = card.getAttribute('data-audio');
    const currentImg = card.querySelector('img');
    const playButtonCard = card.querySelector('.play-overlay i');
    const songTitle = card.querySelector(".baihat").textContent;
    const artistName = card.querySelector(".casi").textContent;

    // Thêm class playing vào card được chọn
    card.classList.add('playing');

    // Cập nhật UI
    document.getElementById('song-name').textContent = songTitle;
    document.getElementById('artist-name').textContent = artistName;
    containerPlay.classList.add('show');
    imgScrThanhNhac.src = currentImg.src;

    // Reset card cũ
    // if (currentCard && currentCard !== card) {
    //     const oldPlayButton = currentCard.querySelector('.play-overlay i');
    //     oldPlayButton.className = 'bx bx-play-circle';
    //     currentCard.classList.remove('playing');
    // }

    // Phát nhạc
    currentCard = card;
    audioPlayer.src = audioSrc;
    audioPlayer.currentTime = 0;
    audioPlayer.play();

    // Cập nhật icon
    document.querySelectorAll('.play-overlay i').forEach(icon => {
      icon.className = 'bx bx-play-circle';
    });
    playButtonCard.className = 'bx bx-pause-circle';
    playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";

    // Thêm bài hát vào history
    updatePlayHistory(card);
  }

  // Event listeners cho card
  songCards.forEach((card, index) => {
    const playOverlay = card.querySelector('.play-overlay');

    // Click vào nút play trên card
    playOverlay.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();

      // Kiểm tra nếu card này đang phát nhạc
      if (currentCard === card) {
        // Toggle play/pause mà không xóa class playing 
        if (!audioPlayer.paused) {
          audioPlayer.pause();
          playOverlay.querySelector('i').className = 'bx bx-play-circle';
          playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
          card.classList.add('playing');
        } else {
          audioPlayer.play();
          playOverlay.querySelector('i').className = 'bx bx-pause-circle';
          playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
          card.classList.add('playing');
        }
        return;
      }

      // Nếu là card khác
      currentIndex = index;
      playMusic(card);
    });

    // Click vào card để chuyển trang
    card.addEventListener('click', () => {
      const songId = card.getAttribute('data-id');
      window.location.href = `DetailCategory copy.php?id_baihat=${songId}`;
    });
  });

  // Xử lý điều khiển phát nhạc
  playButton.addEventListener('click', () => {
    if (!currentCard) return;
    const playButtonCard = currentCard.querySelector('.play-overlay i');

    if (audioPlayer.paused) {
      audioPlayer.play();
      playButtonCard.className = 'bx bx-pause-circle';
      playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
    } else {
      audioPlayer.pause();
      playButtonCard.className = 'bx bx-play-circle';
      playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
    }
  });

  // Xử lý next/prev
  document.getElementById('prev').addEventListener('click', () => {
    const cards = Array.from(songCards);
    if (!currentCard) return;
    currentIndex = (currentIndex - 1 + cards.length) % cards.length;
    playMusic(cards[currentIndex]);
  });

  document.getElementById('next').addEventListener('click', () => {
    const cards = Array.from(songCards);
    if (!currentCard) return;
    currentIndex = (currentIndex + 1) % cards.length;
    playMusic(cards[currentIndex]);
  });

  // Xử lý audio events
  audioPlayer.addEventListener('ended', () => {
    const cards = Array.from(songCards);
    if (!currentCard) return;
    currentIndex = (currentIndex + 1) % cards.length;
    playMusic(cards[currentIndex]);
  });

  audioPlayer.addEventListener('loadedmetadata', () => {
    duration.textContent = formatTime(audioPlayer.duration);
  });

  audioPlayer.addEventListener('timeupdate', () => {
    current.textContent = formatTime(audioPlayer.currentTime);
    progress.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
  });

 
  // Xử lý thanh progress và volume
  progress.addEventListener("input", () => {
    audioPlayer.currentTime = (progress.value / 100) * audioPlayer.duration;
  });

  volume.addEventListener("input", () => {
    audioPlayer.volume = volume.value;
  });

  // Helper functions
  function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes < 10 ? '0' + minutes : minutes}:${secs < 10 ? '0' + secs : secs}`;
  }
</script>


</html>
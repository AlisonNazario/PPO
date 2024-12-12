<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câmera</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <style>
        .camera-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        #video {
            width: 100%;
            max-width: 640px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .camera-controls {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        #canvas {
            display: none;
        }
        #photo {
            max-width: 320px;
            border-radius: 8px;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
<?php include '../navbar.php'; ?>

<div class="container">
    <div class="camera-container">
        <h2 class="mb-4">Acesso à Câmera</h2>
        
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display:none;"></canvas>
        <img id="photo" alt="Captured Photo">

        <div class="camera-controls">
            <button id="capture" class="btn btn-success" disabled>Tirar Foto</button>
        </div>
    </div>
    <script>
        window.onload=function(){
            // Seleciona os elementos
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const photo = document.getElementById('photo');
            const captureButton = document.getElementById('capture');

            // Solicita acesso à câmera
            navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error('Erro ao acessar a câmera:', error);
            });

            // Função para capturar a foto
            captureButton.addEventListener('click', () => {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Converte o conteúdo do canvas em uma imagem
                const dataUrl = canvas.toDataURL('image/png');
                photo.src = dataUrl;
                photo.style.display = 'block'; // Exibe a imagem capturada
            });
        }
    </script>
</div> 
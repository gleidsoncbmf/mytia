<!DOCTYPE html>
<html>
<head>
    <title>Recuperação de Senha</title>
</head>
<body>
    <h1>Recuperação de Senha</h1>
    <p>Olá!</p>
    <p>Você solicitou a recuperação de sua senha. Use o token abaixo para resetar sua senha:</p>
    <p><strong>Token de recuperação:</strong> {{ $token }}</p>

    <p>Se você não solicitou essa alteração, ignore este e-mail.</p>

    <p>Atenciosamente,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>

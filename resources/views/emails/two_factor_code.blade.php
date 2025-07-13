<p>Hola {{ $user->name }},</p>

<p>Por favor ingresa tu código de autenticación que hemos enviado a tu correo.</p>

<p><strong>Código de autenticación: {{ $user->two_factor_code }}</strong></p>

<p>Este código expira en 10 minutos.</p>
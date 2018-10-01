<body style="text-align: center">
    <h1 style="color: #ffffff; background-color: #87b9bf; text-align: center">Oportunidades do Dia {{ today()->format('d-m-Y') }}</h1>

    @include('mail.oportunidades-bb')
    @include('mail.oportunidades-cn')
    @include('mail.oportunidades-io')

</body>

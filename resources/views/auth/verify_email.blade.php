<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h2>{{ trans('authentication.verify_email_title') }}</h2>  
        <div>
            {{ trans('authentication.verify_email_body') }} <br/>
            {{ route('verify.email', $confirmationCode) }}
        </div>
</body>
</html>

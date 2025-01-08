
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        @if (session()->has('message') && isset(session('message')[0]))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit="submit" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="first_name" name="first_name" placeholder="First Name" type="text" wire:model.live="state.first_name">
                        <label for="first_name">First Name</label>
                        {!! APFrmErrHelp::showErrors($errors, 'state.first_name') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="last_name" name="last_name" placeholder="Last Name" type="text" wire:model.live="state.last_name">
                        <label for="last_name">Last Name</label>
                        {!! APFrmErrHelp::showErrors($errors, 'state.last_name') !!}
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="email_address" name="email_address" placeholder="Email Address*" type="email" wire:model.live="state.email_address">
                        <label for="email_address">Email Address*</label>
                        {!! APFrmErrHelp::showErrors($errors, 'state.email_address') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="phone_number" name="phone_number" placeholder="Phone" type="text" wire:model.live="state.phone_number">
                        <label for="phone_number">Phone</label>
                        {!! APFrmErrHelp::showErrors($errors, 'state.phone_number') !!}
                    </div>
                </div>
            </div>
            <div class="form-floating mt-3">
                <textarea class="form-control" id="message" name="message" placeholder="Your Message" wire:model.live="state.message" style="height: 150px;"></textarea>
                <label for="message">Your Message</label>
                {!! APFrmErrHelp::showErrors($errors, 'state.message') !!}
            </div>
            <button type="submit" class="btn btn-primary mt-3">Send Message</button>
            <div id="msgSubmit" class="h3 text-center hidden mt-3"></div>
            <div class="clearfix"></div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>



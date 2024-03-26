<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA</title>
</head>
<body>
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">2FA</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/2mfa/validate">
                        {!! csrf_field() !!}

                        <div class="form-group has-error">
                            <label class="col-md-4 control-label">One-Time Password</label>

                            <div class="col-md-6">
                                <input type="hidden" class="form-control" name="email" value="{{ $email }}">
                                <input type="number" class="form-control" name="code" required>

                                @if(isset($err))
                                <span class="help-block">
                                    <strong>{{ $err }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-mobile"></i>Validate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>


@extends('layout')

@section('title', 'Ticket - '. $ticket[0]->title)
@section('description', $ticket[0]->title)

@section('content')

    @if(Session::has('custom_alert'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                                <span>
                                {{ Session::get('custom_alert') }}
                                    @php
                                        Session::forget('custom_alert');
                                    @endphp
                                </span>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6">
        <ul class="timeline timeline-simple">
            <li class="timeline-inverted">
                <div class="ticket-photo success">
                    <img src="{{asset('assets/img/users')}}/{{$ticket[0]->photo}}" />
                </div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <span class="label label-success">{{$ticket[0]->ticket_login}}</span>
                    </div>
                    <div class="timeline-body">
                        @php echo nl2br($ticket[0]->body); @endphp
                    </div>
                    <h6>
                        <i class="ti-time"></i> Criado em {{date('d-m-Y', strtotime($ticket[0]->created_at))}} às {{date('H:m:i', strtotime($ticket[0]->created_at))}}
                    </h6>
                </div>
            </li>

            @if(Session::has('custom_alert_success'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                                <span>
                                {{ Session::get('custom_alert_success') }}
                                    @php
                                        Session::forget('custom_alert_success');
                                    @endphp
                                </span>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())

                <div class="row">
                    <div class="col-md-12">

                        <div class="alert alert-danger">
                            <span>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach</span>
                            </span>
                        </div>

                    </div>
                </div>

            @endif

            @foreach($replys as $reply)

                <li class="timeline-inverted">
                    <div class="ticket-photo success">
                        <img src="{{asset('assets/img/users')}}/{{$reply->photo}}" />
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <span class="label label-info">{{$reply->ticket_login}}</span>
                        </div>
                        <div class="timeline-body">
                            @php echo nl2br($reply->body); @endphp
                        </div>
                        <h6>
                            Criado em {{date('d-m-Y', strtotime($reply->created_at))}} às {{date('H:m:i', strtotime($reply->created_at))}}
                        </h6>
                    </div>
                </li>
            @endforeach
        </ul>
        @if($ticket[0]->status != "Resolvido")
            <div class="col-md-11 pull-right reply-right">
                <form method="post" action="{{route('admin.managertickets.reply', ['id' => $ticket[0]->id])}}">
                    @csrf
                    <textarea name="body" class="form-control bodyfield"></textarea>
                    <button type="submit" class="btn btn-danger pull-right" formaction="{{route('admin.managertickets.close', ['id' => $ticket[0]->id])}}">Fechar</button>
                    <button type="submit" class="btn btn-success pull-right">Responder</button>
                </form>
            </div>
        @else
            <div class="col-md-11 pull-right reply-right">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger">
                                <span>
                                Este ticket está fechado e não aceita mais respostas.
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <script src="{{asset('assets/js/tinymce.min.js')}}"></script>
    <script>
        tinymce.init({
            selector:'textarea.bodyfield',
            height:500,
            menubar:false,
            plugins:['link', 'table', 'image', 'autoresize', 'lists'],
            toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | table | link image | bullist numlist',
            content_css:[
                '{{asset('assets/css/content.css')}}'
            ],
            images_upload_url:'{{route('imageupload')}}',
            images_upload_credentials:true,
            convert_urls:false
        });
    </script>



@endsection

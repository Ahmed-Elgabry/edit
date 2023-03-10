@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Terms & Condition'))

@push('css_or_js')

<script src="https://cdn.tiny.cloud/1/bw2hsnqehcg1ttb7gb2kap4sxrbshkocrky7vh7izwp13xa9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{\App\CPU\translate('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{\App\CPU\translate('terms_and_condition')}}</li>
            </ol>
        </nav>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between pl-4 pr-4">
                            <div>
                                <h2>{{\App\CPU\translate('terms_and_condition')}}</h2>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('admin.business-settings.update-terms')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label for="editor">{{\App\CPU\translate('terms_and_condition')}}</label>
                                    <textarea class="form-control" id="editor"
                                        name="value">{{$terms_condition->value}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input class="form-control btn-primary" type="submit" name="btn">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
    {{--ck editor--}}
@endpush

<div>
    {{--check if link is not null --}}
    @if (!!$link)
    <object data="{{ asset('storage/'.$link) }}" type="application/pdf" width="100%" height="500px">
        <p>Unable to display PDF file. <a href="{{ asset('storage/'.$link) }}">Download</a> instead.</p>
      </object>
    @else
    <object data="{{ asset('assets/No_files_Upload.pdf') }}" type="application/pdf" width="100%" height="500px">
        <p>Unable to display PDF file. <a href="{{ asset('assets/No_files_Upload.pdf') }}">Download</a> instead.</p>
      </object>
    @endif

</div>

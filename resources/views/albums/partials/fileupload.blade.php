{{-- @if ($album->album_thumb) --}}
@if (true)

    <div class="form-group imgBox">

    <label for="">Thumb</label>
    <input type="file" name="album_thumb" id="" class="form-control inputfile" placeholder="album_thumb" aria-describedby="helpId" value="{{$album->album_thumb}}" >
    <img src="{{asset($album->path)}}" alt="{{$album->album_name}}">

    </div>
        <div>
            <img src="{{$album->album_thumb}}" alt="">
        </div>
    @endif

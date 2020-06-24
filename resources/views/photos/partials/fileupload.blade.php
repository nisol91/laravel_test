{{-- @if ($album->album_thumb) --}}
@if (true)

    <div class="form-group imgBox">

    <label for="">Thumb</label>
    <input type="file" name="img_path" id="" class="form-control inputfile" placeholder="img_path" aria-describedby="helpId" value="{{$photo->img_path}}" >
    <img src="{{asset($photo->path)}}" alt="{{$photo->name}}">
    </div>
    @endif

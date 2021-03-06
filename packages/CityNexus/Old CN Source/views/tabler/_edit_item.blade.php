<tr>
    <td>{{$key}}</td>
    <td>
        <input type="checkbox" name="map[{{$key}}][skip]" @if(isset($item->skip)) checked @endif>
    </td>
    <td><input type="checkbox" name="map[{{$key}}][show]" @if(isset($item->show)) checked @endif></td>
    <td><input type="text" id="name-{{$key}}" name="map[{{$key}}][name]" class="form-control" value="{{ucwords($key)}}"></td>
    <input type="hidden" name="map[{{$key}}][key]" value="{{$key}}">
    <td>
        {{$item->type}}
        <input type="hidden" value="{{$item->type}}" name="map[{{$key}}][type]">
    </td>
    <td>
        <select name="map[{{$key}}][sync]" id="" class="form-control">
            <option value="null"></option>
            @foreach(config('citynexus.sync') as $k => $i)
                <option value="{{$k}}" @if(isset($item->sync) && $item->sync == $k) selected @endif>{{$i}}</option>
            @endforeach
        </select>
    </td>
    <td><select name="map[{{$key}}][push]" id="" class="form-control">
            <option value="null"></option>
            @foreach(config('citynexus.push') as $k => $i)
                <option value="{{$k}}" @if(isset($item->push) && $item->push == $k) selected @endif>{{$i}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="hidden" name="map[{{$key}}][meta]" id="metadata-{{$key}}" @if(isset($item->meta)) value="{{$item->meta}}" @endif>
        <div class="btn btn-primary btn-sm" onclick="addMeta('{{$key}}')">Add</div>
    </td>
</tr>

<?php
if(!isset($selected_terms)){
    $selected_terms = new \Illuminate\Support\Collection(old('terms', []));
}
?>
@foreach ($attributes as $attribute)
    <div class="panel">
        <div class="panel-title"><strong>{{__(':name',['name'=>$attribute->name])}}</strong></div>
        <div class="panel-body">
            <div class="terms-scrollable terms-scrollable-ux">
                @foreach($attribute->terms as $term)
                    <label class="term-item">
                        <input @if(!empty($selected_terms) and $selected_terms->contains($term->id)) checked @endif type="checkbox" name="terms[]" value="{{$term->id}}">
                        <span class="term-name">{{$term->name}}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div> 
@endforeach
<div class="mt-4">
    <x-input-label for="birthYear" value="生年月日" />
    {{-- <pre>{{ $birthYear }} / {{ $birthMonth }} / {{ $birthDay }}</pre> --}}
    <div class="mt-2 flex items-center gap-2">
        <select wire:model.live="birthYear" name="birthYear" id="" class="border rounded text-sm h-9 px-3 pr-8 w-24">
            <option value="">----</option>
            @foreach ($years as $y)
                <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
        </select>
        <span>年</span>

        <select wire:model.live="birthMonth" name="birthMonth" id="" class="border rounded text-sm h-9 px-3 pr-8 w-24">
            <option value="">----</option>
            @foreach ($months as $m)
                <option value="{{ $m }}">{{ $m }}</option>
            @endforeach
        </select>
        <span>月</span>


        <select wire:model.live="birthDay" name="birthDay" id="" class="border rounded text-sm h-9 px-3 pr-8 w-24">
            <option value="">----</option>
            @foreach ($days as $d)
                <option value="{{ $d }}">{{ $d }}</option>
            @endforeach
        </select>
        <span>日</span>
    </div>
</div>

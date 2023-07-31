<div class="top-list my-4">
  <div class="glide w-full">
    <div class="glide__track mx-5" data-glide-el="track">
      <ul class="glide__slides">
        @foreach($topListItems as $index => $item)
        @if ($index < $visibleCount) <li class="glide__slide card text-center">
          <img src="{{ $item->{$logoOrScreenshotKey} }}" class="card__img rounded-2xl inline-block" alt="{{ $item->name }}">
          <h5 class="card__title font-bold my-4 text-2xl">{{ $item->name }}</h5>
          <a href="{{ $item->{$linkOrUrlKey} }}" class="bg-yellow-400 hover:bg-yellow-500 text-black text-base px-5 py-3 inline-block rounded-2xl">Visit</a>
          </li>
          @endif
          @endforeach
      </ul>
    </div>
    <div class="glide__arrows" data-glide-el="controls">
      <button class="glide__arrow glide__arrow--left left-0 rounded-full bg-white text-black border-black hover:bg-black hover:text-white duration-300 ease-in-out" data-glide-dir="<">
        <div class="h-6 w-6 text-black  flex justify-center items-center my-auto text-current">
          <svg width="8" height="16" viewBox="0 0 8 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-current">
            <path d="M7.41463 16C7.28455 16 7.02439 16 6.89431 15.8774L0.91057 10.2375C0.260164 9.62452 0 8.88889 0 8.03065C0 7.17241 0.390245 6.43678 0.91057 5.82376L6.89431 0.183908C7.15447 -0.0613027 7.54471 -0.0613027 7.80488 0.183908C8.06504 0.429119 8.06504 0.796935 7.80488 1.04215L1.82114 6.68199C1.04065 7.41762 1.04065 8.52107 1.82114 9.25671L7.80488 14.8966C8.06504 15.1418 8.06504 15.5096 7.80488 15.7548C7.80488 16 7.54472 16 7.41463 16Z" fill="currentColor" />
          </svg>
        </div>
      </button>
      <button class="glide__arrow glide__arrow--right right-0 rounded-full bg-white text-black border-black hover:bg-black hover:text-white duration-300 ease-in-out" data-glide-dir=">">
        <div class="h-6 w-6 text-black flex justify-center items-center my-auto text-current">
          <svg width="8" height="16" viewBox="0 0 8 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-current">
            <path d="M0.585365 16C0.715446 16 0.975608 16 1.10569 15.8774L7.08943 10.2375C7.73984 9.62452 8 8.88889 8 8.03065C8 7.17241 7.60976 6.43678 7.08943 5.82376L1.10569 0.183908C0.845527 -0.0613027 0.455285 -0.0613027 0.195122 0.183908C-0.0650406 0.429119 -0.0650406 0.796935 0.195122 1.04215L6.17886 6.68199C6.95935 7.41762 6.95935 8.52107 6.17886 9.25671L0.195122 14.8966C-0.0650406 15.1418 -0.0650406 15.5096 0.195122 15.7548C0.195122 16 0.455284 16 0.585365 16Z" fill="currentColor" />
          </svg>
        </div>
      </button>
    </div>
  </div>
</div>
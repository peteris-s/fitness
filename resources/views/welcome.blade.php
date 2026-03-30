<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="description" content="Track calories, create workouts and follow your fitness progress with FitTracker">
</head>
{{-- Welcome lapas veidne; ja tiek padots `$featured`, attēlo public workouts sadaļu. --}}
<body class="bg-gray-900 text-white min-h-screen" style="background-color: #0f172a;">
    
    <nav class="bg-transparent">
        <div class="max-w-4xl mx-auto px-6 py-3 grid grid-cols-3 items-center">
        
        <div class="flex justify-start">
          <a href="/" class="flex items-center">
            <div class="rounded-md overflow-hidden bg-gray-900 p-1 dark:bg-transparent">
              <x-application-logo class="h-10 w-10 block dark:invert" />
            </div>
          </a>
        </div>

        
            <div class="flex justify-center">
          <div class="text-xl font-semibold text-white">FitTracker</div>
        </div>

        
        <div class="flex justify-end">
          <div class="flex items-center gap-3">
            @auth
              <a href="{{ route('dashboard') }}" class="text-sm px-3 py-1.5 border border-transparent bg-blue-600 text-white rounded">Dashboard</a>
              <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <button type="submit" class="text-sm px-3 py-1.5 text-white hover:text-gray-200">Logout</button>
              </form>
            @else
              @if (Route::has('login'))
                <a href="{{ route('login') }}" class="text-sm px-3 py-1.5 text-white hover:text-gray-200">Login</a>
              @endif

              <a href="{{ route('register') }}" class="text-sm px-3 py-1.5 bg-white text-gray-900 dark:bg-gray-700 dark:text-white rounded" style="position:relative;z-index:10;">Register</a>
            @endauth
          </div>
        </div>
      </div>
    </nav>

    
    <section class="h-screen bg-fixed bg-center bg-cover relative"
             style="background-image: url('{{ asset('fit1.jpeg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-65 flex flex-col items-center justify-center gap-40 text-center px-4">
          <h2 class="text-white text-4xl md:text-6xl lg:text-7xl font-bold">This is where your fitness journey starts!</h2>
          <p class="text-white text-lg md:text-xl max-w-2xl">Scroll down for more info about FitTracker!<br> ↓</p>
        </div>
    </section>
    <section class="h-screen bg-fixed bg-center bg-cover relative"
             style="background-image: url('{{ asset('fit2.avif') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-65 flex items-center justify-center px-4">
          <div class="max-w-4xl w-full bg-transparent rounded-lg p-8 text-white">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-4">Completely free, no ads, no hidden fees</h2>
            <p class="text-center mb-6">If you stay consistent, you'll see progress, we help make it simple.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="p-4 bg-black/60 rounded text-center">
                <div class="w-10 h-10 mx-auto flex items-center justify-center bg-blue-600 rounded-full font-bold mb-2">1</div>
                <div class="font-semibold">Sign up</div>
                <div class="text-sm text-gray-300">Create a free account, quick and easy.</div>
              </div>

              <div class="p-4 bg-black/60 rounded text-center">
                <div class="w-10 h-10 mx-auto flex items-center justify-center bg-blue-600 rounded-full font-bold mb-2">2</div>
                <div class="font-semibold">Pick a goal</div>
                <div class="text-sm text-gray-300">Choose a plan that fits your week.</div>
              </div>

              <div class="p-4 bg-black/60 rounded text-center">
                <div class="w-10 h-10 mx-auto flex items-center justify-center bg-blue-600 rounded-full font-bold mb-2">3</div>
                <div class="font-semibold">Log & improve</div>
                <div class="text-sm text-gray-300">Track workouts and meals, see progress.</div>
              </div>
            </div>

            
          </div>
        </div>
    </section>
    
    
    <section class="h-screen bg-fixed bg-center bg-cover relative"
             style="background-image: url('{{ asset('fit3.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-65 flex items-center justify-center px-4">
          <div class="max-w-4xl w-full bg-black/50 rounded-lg p-8 text-white">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-4">Why people love FitTracker</h2>
            <p class="text-center mb-6">Simple workouts, quick calorie logging, and progress you can actually see, made to fit your life.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="grid grid-cols-3 gap-4 text-center">
                <div class="p-4 bg-gray-900/60 rounded">
                  <div class="text-2xl font-bold">Easy to start</div>
                  <div class="text-sm text-gray-300">No setup, just jump in</div>
                </div>
                <div class="p-4 bg-gray-900/60 rounded">
                  <div class="text-2xl font-bold">Short workouts</div>
                  <div class="text-sm text-gray-300">20–30 minute routines</div>
                </div>
                <div class="p-4 bg-gray-900/60 rounded">
                  <div class="text-2xl font-bold">Track progress</div>
                  <div class="text-sm text-gray-300">See real improvements over time</div>
                </div>
              </div>

              <ul class="space-y-2 text-sm">
                <li><span class="font-bold">Plans that fit your life:</span> No fluff, just real, doable workouts.</li>
                <li><span class="font-bold">Easy logging:</span> Track meals and workouts in seconds.</li>
                <li><span class="font-bold">Your data, your rules:</span> Keep it, export it, or delete it, it's yours.</li>
              </ul>
            </div>

            <div class="text-center mt-6">
              <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded">Try it free</a>
            </div>
          </div>
        </div>
    </section>

    
    <section class="bg-gray-900">
      <div class= "max-w-4xl mx-auto px-6 py-20 text-center justify-center items-center flex flex-col gap-6">
      <h1 class="text-8xl md:text-9xl font-bold mb-4 text-white">Goodluck!</h1>
    </div>
    </section>

      @if(!empty($featured) && $featured->count())
      <section class="bg-gray-900">
        <div class="max-w-6xl mx-auto px-6 py-20">
          <h2 class="text-3xl font-bold text-white mb-6">Featured public workouts</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured as $workout)
              <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                <div class="flex justify-between items-start mb-2">
                  <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $workout->name }}</h3>
                  @php $c = $workout->difficulty === 'beginner' ? 'green' : ($workout->difficulty === 'intermediate' ? 'yellow' : 'red'); @endphp
                  <span class="text-xs px-2 py-1 rounded bg-{{ $c }}-100 text-{{ $c }}-800 dark:bg-{{ $c }}-800 dark:bg-opacity-30 dark:text-{{ $c }}-200">{{ $workout->difficulty }}</span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($workout->description, 80) }}</p>
                <div class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                  <p>⏱️ {{ $workout->duration_minutes }} minutes</p>
                  <p>👤 {{ $workout->user->name }}</p>
                </div>
                <div class="flex gap-2">
                  <a href="{{ route('workouts.show', $workout) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</a>
                  @auth
                    @if($workout->is_public && auth()->id() !== $workout->user_id)
                      <form method="POST" action="{{ route('plans.copy', $workout) }}">@csrf<button class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Copy</button></form>
                    @endif
                  @endauth
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
      @endif

    

</body>
</html>
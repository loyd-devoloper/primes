<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-cloak x-data="{ darkMode: localStorage.getItem('darkMode') == 'true' }"
    class=" bg-[#F5F5F5] dark:bg-bgDark  min-h-[100svh]" :class="{ 'dark': darkMode === true }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo e(asset('login.png')); ?>    " type="image/x-icon">
    <title><?php echo e($title ?? 'Prime System'); ?></title>

    <?php echo \Filament\Support\Facades\FilamentAsset::renderStyles() ?>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js','resources/scss/christmas.scss']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 4px;
            height: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* HTML: <div class="loader"></div> */
        .loader {
            width: 35px;

            aspect-ratio: 1;
            --c: no-repeat linear-gradient(#ffffff 0 0);
            background:
                var(--c) 0 0,
                var(--c) 100% 0,
                var(--c) 100% 100%,
                var(--c) 0 100%;
            animation:
                l2-1 2s infinite,
                l2-2 2s infinite;
        }

        .loadingContainer {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes l2-1 {
            0% {
                background-size: 0 4px, 4px 0, 0 4px, 4px 0
            }

            12.5% {
                background-size: 100% 4px, 4px 0, 0 4px, 4px 0
            }

            25% {
                background-size: 100% 4px, 4px 100%, 0 4px, 4px 0
            }

            37.5% {
                background-size: 100% 4px, 4px 100%, 100% 4px, 4px 0
            }

            45%,
            55% {
                background-size: 100% 4px, 4px 100%, 100% 4px, 4px 100%
            }

            62.5% {
                background-size: 0 4px, 4px 100%, 100% 4px, 4px 100%
            }

            75% {
                background-size: 0 4px, 4px 0, 100% 4px, 4px 100%
            }

            87.5% {
                background-size: 0 4px, 4px 0, 0 4px, 4px 100%
            }

            100% {
                background-size: 0 4px, 4px 0, 0 4px, 4px 0
            }
        }

        @keyframes l2-2 {

            0%,
            49.9% {
                background-position: 0 0, 100% 0, 100% 100%, 0 100%
            }

            50%,
            100% {
                background-position: 100% 0, 100% 100%, 0 100%, 0 0
            }
        }
    </style>

</head>

<body>

    <?php echo e($slot); ?>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notifications');

$__html = app('livewire')->mount($__name, $__params, 'lw-3969274642-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php if(auth()->guard()->check()): ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('database-notifications');

$__html = app('livewire')->mount($__name, $__params, 'lw-3969274642-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php endif; ?>
    <?php echo \Filament\Support\Facades\FilamentAsset::renderScripts() ?>
    

</body>

</html>
<?php /**PATH /home/loyd-deped/Desktop/www/PDS/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>
<?php

namespace App\Twig\Runtime;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\RuntimeExtensionInterface;

class CompetencePageTitleRuntime implements RuntimeExtensionInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function doCompetenceTitle(): mixed
    {
        $request = $this->requestStack->getCurrentRequest();
        if (is_null($request)) {
            return 'Posts';
        }
        $routeName = $request->get('_route');

        return match ($routeName) { /** @phpstan-ignore-line */
            'homepage' => 'Posts',
            'projects' => 'Projets',
            'articles' => 'Articles',
        };
    }
}

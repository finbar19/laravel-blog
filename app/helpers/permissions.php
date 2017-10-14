<?php

function check_user_permissions($request, $actionName = NULL, $id = NULL)
{
  $currentUser = $request->user();
  //get current action name
  if ($actionName) {
      $currentActionName = $actionName;
  }
  else {
      $currentActionName = $request->route()->getActionName();
  }
  list($controller, $method) = explode('@', $currentActionName);
  $Controller = str_replace(["App\\Http\\Controllers\\Backend\\", "Controller", "Controller"], "", $controller);

  $crudPermissionsMap = [
    'crud' => ['create', 'store', 'edit', 'update', 'destroy', 'restore', 'forceDestroy']
  ];
  $classesMap = [
    'Blog' => 'post',
    'Categories' => 'category',
    'Users' => 'user'
  ];

  foreach ($crudPermissionsMap as $permission => $methods)
  {
      if (in_array($method, $methods) && isset($classesMap[$controller]))
      {
          $className = $classesMap[$controller];

          if ($className == 'post' && in_array($method, ['edit', 'update', 'destroy', 'restore', 'forceDestroy']))
          {
              $id = !is_null($id) ? $id : $request->route('blog');

              if ($id
                  && (!$currentUser->can('update-others-post') || !$currentUser->can('delete-others-post')))
              {
                  $post = \App\Post::find($id);
                  if ($post->author_id !== $currentUser->id)
                  {
                    return false;
                  }
              }
          }
          else if (! $currentUser->can("{$permission}-{$className}"))
          {
              return false;
          }
      }
  }
  return true;

}

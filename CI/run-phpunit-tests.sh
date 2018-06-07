#!/usr/bin/env bash

search_dir=tests/suites/

echo "\n\n==[ Running phpunit tests / $search_dir ]==========================\n";

for entry in "$search_dir"/*
do
  echo "\n\n----[ Executing $entry file ]----------------";
  sh $entry;
done

echo "\n\n======================================================\n";

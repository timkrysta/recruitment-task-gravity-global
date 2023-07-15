# Backend/Full-stack recruitment task

<img src="https://github.com/laravel/sanctum/workflows/tests/badge.svg" alt="Build Status" style="max-width: 100%;">

## Architecture
I have decided to create a separate backend API in PHP that will be utilized by the frontend done in TypeScript and styles in Sass.

Such an approach is better than monolith because it's modular; We can replace the whole frontend without affecting our backend or reverse.

## Demo
I have hosted it on my private server for you: [gravity-global.timkrysta.com/](https://gravity-global.timkrysta.com:8080/)

## Notes
To keep this task free from dependencies I have decided to stick with primitive file-based routing. In a real-world scenario, I would make a Router and create a routes.php where we could store all endpoints and associate a controller's method to it.

Additionally in a real-world scenario, the operation of deleting a user from the data source would be more efficient than the current O(n) if we were to utilize a database instead of reading/writing from/to a file.

## Hands on keyboard time
- 2023-06-26
    - 13:15 - 17:09
- 2023-06-29
    - 7:08 - 09:19
    - 14:45 - 18:00
- 2023-07-12
    - 9:54 - 13:04
- 2023-07-14
    - 15:35 - 17:51
- 2023-07-15
    - 10:13 - 11:39


## Author
[Tymoteusz Krysta](https://www.linkedin.com/in/tim-krysta/) - krystatymoteusz@gmail.com

<br>

## Final provisions
Frontend and Backend have their own README.md.

# YouTube to WordPress XML

__Generate WordPress XML exports from YouTube playlists.__

## Usage

Using cURL, you can grab the results of the page.

	curl -O "http://localhost:8888/github/YouTube%20to%20WordPress%20XML/?username=whyisjake&start=1&offset=1"

There are three query parameters to add, `offset`, `username`, and `start`.

### Query String Parameters

1. `offset`: How far to offset the feed. Ideally, you would want to start at 1, and then go from there.
2. `username`: Username of the YouTube feed that you want to retrieve.
3. `start`: With start, this is the start index of the feed. The feed will grab 50 videos at a time, so if you have 50 videos in a playlist, you would offset this number by 50 on the next pass.

## Batch Usage

If you want to pull down a lot of playlists at the same time, you can use the following method. Adding the numbers in the curly braces will loop through each option, getting all of the playlists. The second flag will name each file videos-export-#.xml.

	curl "http://localhost:8888/github/YouTube%20to%20WordPress%20XML/?username=makemagazine&start=1&offset={1,2,3,4,5,6,7,8,9,10}" -o "videos-export-#1.xml"
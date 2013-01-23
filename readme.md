# YouTube-to-WordPress-XML

__Generate WordPress XML exports from YouTube playlists.__

## Usage

Using cURL, you can grab the results of the page.

	curl -O http://localhost:8888/video-importer/?offset=1&username=makezine&start=1

There are three query parameters to add, `offset`, `username`, and `start`.

### Query String Parameters

1. _offset_: How far to offset the feed. Ideally, you would want to start at 1, and then go from there.
2. _username_: Username of the YouTube feed that you want to retrieve.
3. _start_: With start, this is the start index of the feed. The feed will grab 50 videos at a time, so if you have 50 videos in a playlist, you would offset this number by 50 on the next pass.
### Dataphyre CDN Server Module Documentation

The **CDN Server Module** in Dataphyre manages content storage, replication, retrieval, and deletion for the CDN. It ensures content is efficiently stored and served based on redundancy levels and server priorities. It also supports secure streaming, caching, and content integrity verification.

#### Core Components

1. **Configuration and Initialization**
   - **CDN Server Class (`cdn_server`)**: The main class handles CDN operations.
   - **Properties**:
     - **`$storage_filepath`**: Defines the storage path for CDN blocks.
     - **`$inodes_per_directory_depth`**: Sets the inode depth for directory encoding.
     - **`$cdn_server_name`**: Stores the server name based on the configuration.

2. **Content Storage and Management**
   - **`add_content($origin_url, $iteration, $encryption)`**: Adds new content to the CDN server. If necessary, retries up to a specified number of attempts.
   - **`assign_block($method_on_new)`**: Finds or creates a unique block ID for content storage.
   - **`stream_remote_content_to_block($origin_url, $blockid, $encryption)`**: Downloads content from a remote URL to a local CDN block.
   - **`replicate_content($blockid, $decoded_blockpath, $remote_url, $expected_hash)`**: Replicates content from one server to another based on CDN configuration, ensuring redundancy.

3. **Encoding and Decoding**
   - **`encode_blockpath($blockpath)`**: Encodes a block path for CDN storage compatibility.
   - **`decode_blockpath($blockpath)`**: Decodes the encoded block path back to its original form.
   - **`blockid_to_blockpath($blockid)`** and **`blockpath_to_blockid($blockpath)`**: Convert between block IDs and paths, enabling efficient directory mapping and retrieval.

4. **Content Retrieval and Streaming**
   - **`display_file_content($blockpath, $parameters)`**: Displays a file's content based on its block path and MIME type.
   - **`display_remote_file_content($blockpath, $parameters)`**: Retrieves and streams content from a remote server if it’s not found locally.
   - **`stream_file($filepath, $parameters)`**: Streams a file directly from the server, with optional decryption.
   - **`stream_video($filepath, $format, $parameters)`**: Streams video files, adjusting bitrate if specified.
   - **`display_image($filepath, $parameters)`**: Displays an image, with optional transformations (resizing, cropping).

5. **Resource Management and Purging**
   - **`discard_content($blockid)`**: Discards content from the CDN by reducing the replication count or deleting the file.
   - **`purge_content($blockid)`**: Permanently deletes content from storage and resets the use count in the database.
   - **`enforce_block_integrity($blockid, $expected_hash)`**: Verifies file integrity against an expected hash. If corrupted, the file is discarded and marked for re-replication.

6. **Utility and Cache**
   - **`get_mime_type($filename)`**: Determines the MIME type based on file extension or by reading the file contents.
   - **`get_folder($blockpath)`**: Retrieves the storage directory for a given block path.
   - **`stretch_image($image, $new_width, $new_height)`** and **`reframe_image($image, $new_width, $new_height)`**: Adjust image dimensions based on specific transformations.
   - **Caching**: Uses cache keys to store and retrieve compressed or modified images to optimize loading times.

7. **Error Handling**
   - **`cannot_display_content($error_string, $status_code)`**: Displays an error page if content cannot be served, showing a custom error message.
   - **Retries**: Implements retries for various functions like streaming content or adding new blocks to ensure resilience.

#### Summary

The Dataphyre CDN Server Module is a comprehensive solution for managing and serving content in a distributed CDN setup. By supporting multiple replication and retrieval options, content redundancy, integrity checks, and error handling, the module ensures robust and scalable content delivery. It efficiently serves diverse content types while managing resources through caching and controlled purging, making it well-suited for high-demand applications.
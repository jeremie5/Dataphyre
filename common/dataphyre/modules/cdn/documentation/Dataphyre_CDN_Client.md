### Dataphyre CDN Client Module Documentation

The **CDN Client Module** within Dataphyre provides an interface to manage, propagate, and retrieve content from a CDN. It includes functionality for encoding, decoding, and transmitting resources, as well as tools for ingesting HTML resources and updating their CDN paths.

#### Core Functionalities

1. **Configuration and Initialization**
   - **`cdn` Class**: The primary class, handling CDN interactions.
   - **`$inodes_per_directory_depth`**: Sets the depth for directory encoding, used in CDN block management.

2. **URL and Path Management**
   - **`block_url($encoded_blockpath, $parameters)`**: Generates a full URL to a specific CDN block, optionally with query parameters.
   - **`encode_blockpath($blockpath)`**: Encodes a block path as a CDN-safe string.
   - **`decode_blockpath($blockpath)`**: Decodes a previously encoded block path back to its original form.

3. **Block Identification and Conversion**
   - **`blockpath_to_blockid($blockpath)`**: Converts a block path into a unique block ID, which can be used for CDN operations.
   - **`blockid_to_blockpath($blockid)`**: Converts a block ID back into a block path, reversing the `blockpath_to_blockid` function.

4. **Usage Tracking**
   - **`update_use_count($blockpath, $amount)`**: Updates the usage count for a given CDN block, incrementing or decrementing as specified. If the count reaches zero, the block may be purged from the CDN.

5. **Resource Ingestion**
   - **`ingest_resources($html, $resource_limit, $known_changes)`**: Scans and ingests various resources (like images, videos, scripts, and stylesheets) from HTML content, replacing local paths with CDN paths based on a defined pattern. Limits the number of resources processed if `$resource_limit` is set.
   - **Supported Resource Types**:
     - **Images**: `<img>` tags.
     - **Videos**: `<source>` tags.
     - **Scripts**: `<script>` tags.
     - **Stylesheets**: `<link rel="stylesheet">` tags.
     - **Audio**: `<audio>` tags.
     - **Iframes**: `<iframe>` tags.
     - **CSS Backgrounds**: `url(...)` within CSS.
     - **Icons**: `<link rel="icon|shortcut icon">`.
     - **Fonts**: `@font-face` rules in CSS.
     - **Source in Picture**: `<source srcset>` tags in `<picture>` elements.
     - **PDFs**: `<object type="application/pdf">` tags and links to PDF files.
     - **SVG Images**: `<img src="...svg">` tags.

6. **File Propagation and Encryption**
   - **`propagate($file, $encryption)`**: Propagates a file to the CDN. Optionally supports encryption for secure file storage and access. If the file already exists on the CDN (determined by hash), it skips uploading and returns the existing block path.

#### Utility and Error Handling

The CDN Client module includes additional functionality to handle errors and track CDN events:
   - **Error Logging**: `tracelog` calls log errors for actions like file transmission failures, JSON decoding errors, and missing CDN block paths.
   - **Retries**: `propagate` includes a retry mechanism to attempt file upload multiple times before failing.

#### Summary

The Dataphyre CDN Client module provides a robust solution for managing and integrating CDN resources. By enabling ingestion, URL conversion, and resource management, it ensures assets are efficiently stored, tracked, and served from a CDN, supporting efficient and scalable application performance. The module’s error handling and retry mechanisms provide reliability in managing CDN transactions, making it suitable for complex and high-traffic applications.
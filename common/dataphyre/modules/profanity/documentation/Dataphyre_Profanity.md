### Dataphyre Profanity Module Documentation

The **Profanity Module** in Dataphyre is designed to detect and score instances of profanity across various languages, accounting for different types of swearing such as abusive, emphatic, or cathartic. This module uses a combination of text analysis and rule-based pattern matching to detect and analyze profanity in user input, enhancing moderation capabilities for applications that integrate it.

### Key Profanity Types

- **Dysphemistic Swearing**: Conveys negative connotations about subjects or audiences (e.g., "You look like shit!").
  - **Dataset**: `swearing_dysphemistic.php`
  
- **Abusive Swearing**: Intended to insult or intimidate (e.g., "Fuck you!").
  - **Dataset**: `swearing_abusive.php`

### Additional Content Sensitivity Components

These are other content moderation categories supported by existing datasets:

- **CSAM (Child Sexual Abuse Material)**: Used to detect illegal content related to child exploitation.
  - **Dataset**: `csam.php`

- **Extremism**: Detects terms associated with radical or extremist ideologies.
  - **Dataset**: `extremism.php`

- **Politically Sensitive**: Flags content that may be sensitive or controversial in political contexts.
  - **Dataset**: `politically_sensitive.php`

- **Product**: Detects generic product-related terms.
  - **Dataset**: `product.php`

- **Adult Products**: Flags products with adult or explicit themes.
  - **Dataset**: `product_adult.php`

- **Self-Harm**: Flags terms related to self-harm or suicidal ideation.
  - **Dataset**: `self_harm.php`

#### Components

1. **Initialization**
   - **`__construct()`**: Initializes the profanity module with an instance of `fulltext_engine`, which powers the full-text search and matching functionalities.

2. **Methods**

   - **`evaluate($string, $ruleset, $language = 'en')`**:
     - Detects and scores profane content within a given string based on specified rules and language.
     - Loads language-specific profanity datasets from the `datasets` directory and uses the `unscrub` method to preprocess input.
     - Returns `false` if no profanity is detected.

   - **`unscrub($string, $languages = ['en'])`**:
     - Attempts to "unscrub" disguised profane words by normalizing common patterns used to mask profanity.
     - **Supported Unscrubbing Rules**:
       - **Sequential Character Splits**: Replaces split characters (e.g., `sh!t` to `shit`).
       - **Domain Disguised**: Identifies and corrects words split by common domain extensions (e.g., `sh.it` to `shit`).
       - **Email Disguised**: Reconstructs profanity masked as emails (e.g., `f u@example.com` to `f**k`).
       - **Deceptive Characters**: Converts visually similar characters or leetspeak (e.g., `@ss` to `ass`).
     - Returns an array with:
       - `unscrubbed`: The normalized version of the string.
       - `original`: The original input.
       - `matches`: Matched unscrubbed patterns for reference.

   - **`verify($string, $rules, $language = 'en')`**:
     - Verifies if the input string contains any profane words from the given `rules` dataset.
     - Uses the `fulltext_engine` to match words with predefined profanity rules.
     - Calculates a profanity score based on contextual modifiers (e.g., immediately followed by certain words).
     - **Scoring Contexts**:
       - **Base Weight**: Default weight for detected profanity.
       - **Modifier Rules**: Modifies scores based on contextual words:
         - **Position-Based**: Words that appear before or after the profane word.
         - **Sentence-Based**: Profanity appearing within the same sentence as certain words.
       - **Score Calculation**:
         - The score is normalized between 0 and 1, based on the total score range of detected profane words.
     - Returns:
       - `matches`: Array of matched profane words.
       - `score`: Normalized profanity score indicating severity.

#### Example Workflow

For a given text, `"This is f*cking awesome!"`, using an English language profanity ruleset:
- **Step 1**: **Unscrubbing** detects and normalizes `f*cking` to `fucking`.
- **Step 2**: **Verification** identifies `fucking` as profane, matches it against context rules, and calculates a score based on its presence, intensity, and sentence context.
- **Output**:
  ```php
  [
    'matches' => ['fucking'],
    'score' => 0.8 // depending on context and ruleset weight
  ]
  ```

#### Summary

The Profanity Module provides a comprehensive solution for detecting, normalizing, and scoring profanity with context-sensitive analysis. It supports multiple languages, identifies masked words, and allows customized rule-based scoring, making it a powerful tool for content moderation in applications.
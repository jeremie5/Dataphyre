# AceIt Engine Documentation

## Overview

The AceIt Engine is a module within the Dataphyre framework that provides a highly customizable framework for conducting A/B tests and experiments. It is designed to allow developers to build and extend A/B testing functionalities suited to their application needs.

Rather than being a turnkey A/B testing solution, AceIt Engine provides low-level tools and utilities to implement, manage, and analyze experiments efficiently. This modular approach ensures flexibility and adaptability for a wide range of use cases.

---

## Features
- **Experiment Definition**: Define experiments with custom eligibility, environmental factors, and reporting mechanisms.
- **Dynamic Group Allocation**: Assign users to control or test groups based on eligibility criteria.
- **Metric Tracking**: Collect and store metrics for experiments, with custom callbacks for score calculation.
- **Real-Time Experiment Management**: Manage ongoing experiments and dynamically adjust based on outcomes.
- **Aggregation and Reporting**: Aggregate experiment data over different timeframes and generate detailed reports.
- **Session Integration**: Utilize PHP sessions to manage ongoing experiments.
- **Scalability**: Supports large-scale experimentation with SQL-based persistence and modular callbacks.

---

## Key Functions

### 1. `define_experiment`

Defines an experiment and initializes its parameters.

**Syntax**:
```php
dataphyre\aceit_engine::define_experiment(
    string $experiment_name,
    array $experiment_parameters,
    array $environmental_factors,
    callable $eligibility_callback,
    callable $metrification_callback,
    callable $reporting_callback,
    string $aggregation = "hourly"
);
```

**Parameters**:
- `$experiment_name`: Unique identifier for the experiment.
- `$experiment_parameters`: Includes `start`, `period`, `required_sample_size`, and optional `save_callback`.
- `$environmental_factors`: Environmental variables (e.g., `useragent`, `userid`).
- `$eligibility_callback`: Determines group assignment (`control`, `test`, etc.).
- `$metrification_callback`: Processes metrics and calculates scores.
- `$reporting_callback`: Handles experiment result reporting.
- `$aggregation`: Aggregation granularity (`hourly` or `daily`).

**Example**:
```php
dataphyre\aceit_engine::define_experiment(
    "exp_larger_product_title_font",
    [
        "start" => strtotime("2024-01-31 08:30"),
        "period" => strtotime("7 days", 0),
        "required_sample_size" => 100,
        "save_callback" => function($experiment) {
            // Custom save logic
        }
    ],
    [
        "useragent" => $_SERVER['HTTP_USER_AGENT'],
        "userid" => $userid
    ],
    function() {
        global $useragent;
        return str_contains($useragent, "mobile") ? "mobile_device" : "control";
    },
    function($events) {
        return array_sum(array_column($events, 'value')) / count($events);
    },
    function($experiment_name, $leading_group) {
        email::create(config("app/webmaster_email"), "plain", [
            "subject" => "Experiment Results: $experiment_name",
            "body" => "Leading group: $leading_group."
        ]);
    },
    "daily"
);
```

---

### 2. `get_group`

Retrieves the assigned group for a user in a specific experiment.

**Syntax**:
```php
string dataphyre\aceit_engine::get_group(string $experiment_name);
```

**Example**:
```php
$group = dataphyre\aceit_engine::get_group("exp_larger_product_title_font");
```

---

### 3. `metricize`

Logs metrics for an experiment.

**Syntax**:
```php
bool dataphyre\aceit_engine::metricize(string $experiment_name);
```

**Example**:
```php
dataphyre\aceit_engine::metricize("exp_larger_product_title_font");
```

---

### 4. `event`

Logs an event related to one or more experiments.

**Syntax**:
```php
void dataphyre\aceit_engine::event(string $event_name, mixed $event_value, string ...$experiment_names);
```

**Example**:
```php
dataphyre\aceit_engine::event("button_click", 1, "exp_larger_product_title_font");
```

---

### 5. `aggregate_experiment`

Aggregates experiment data based on the specified granularity.

**Syntax**:
```php
void dataphyre\aceit_engine::aggregate_experiment(string $experiment_name, string $granulation = "hourly");
```

**Example**:
```php
dataphyre\aceit_engine::aggregate_experiment("exp_larger_product_title_font", "daily");
```

---

### 6. `chart_experiment`

Generates a chart of aggregated experiment results.

**Syntax**:
```php
array dataphyre\aceit_engine::chart_experiment(string $experiment_name, ?string $test_group, ?array $parameters);
```

**Example**:
```php
$data = dataphyre\aceit_engine::chart_experiment("exp_larger_product_title_font", "test", [
    "start_date" => "2024-01-01",
    "end_date" => "2024-01-07"
]);
```

---

## Data Persistence

The AceIt Engine stores experiment data in JSON files or SQL tables, depending on the configuration.

- **Experiment Data**: Stored in `experimentation_data.json` or a database table.
- **Metric Data**: Logged in the `dataphyre.aceit_engine_experiments` table.
- **Session Data**: Managed through PHP sessions (`$_SESSION`).

---

## Usage Example

The following example illustrates a simple A/B test:

**Objective**: Test whether a larger font size improves user experience on mobile devices.

**Implementation**:
```php
switch(dataphyre\aceit_engine::get_group("exp_larger_product_title_font")) {
    case "mobile_device":
        $font_size = "16px";
        break;
    default:
        $font_size = "12px";
}
```

**Feedback Form Integration**:
```php
dataphyre\core::register_dialback("FEEDBACK_FORM", function($score, $comment) {
    dataphyre\aceit_engine::metricize("exp_larger_product_title_font");
});
```

---

## Recommendations

- **Custom Save Callbacks**: Use the `save_callback` parameter for advanced data persistence needs.
- **Dynamic Adjustments**: Modify group eligibility dynamically using the `eligibility_callback`.
- **Granularity**: Choose the appropriate aggregation granularity for your reporting needs.
- **Extensibility**: Extend AceIt Engine functionalities by overriding key methods or adding additional callbacks.

This framework empowers developers to build robust and scalable A/B testing systems that adapt to unique application requirements.
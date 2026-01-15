# Self-Review Preparation Guide

This guide is designed to help you build your personal Confluence self-review page progressively. Follow these steps and answer the questions to gather the necessary material.

## Phase 1: Projects, OKRs, and Goals

**Goal:** List the significant work you've done.

### Reflection Questions:
1.  **What were the main projects you worked on in the last review period?**
    *   *Prompt:* Look at your Jira board, calendar, or stand-up notes.
    *   *List them out.*
2.  **For each project, what was the specific time period?**
    *   *Prompt:* Approximate start and end dates (e.g., "Oct 2025 - Dec 2025").
3.  **What was your specific role?**
    *   *Questions:* Were you a sole contributor? Did you lead a specific feature? Did you do code reviews primarily?
4.  **Who did you cooperate with?**
    *   *Prompt:* List frontend devs, PMs, QAs, or other backend devs you interacted with daily.
5.  **What were the concrete results?**
    *   *Questions:* Did you deliver the feature on time? Did it reduce bugs? Did it improve performance?
    *   *Action:* Find 1-3 links or screenshots (dashboards, feature demos, released UI) as evidence.

## Phase 2: Quantitative Data (GitHub Activity)

**Goal:** Provide objective data on your coding activity.

### Data Points Needed:
For every month in the review period, gather:
*   **Commits:** Number of commits.
*   **Pull Requests:** Number of PRs opened.
*   **Reviews:** Number of PRs reviewed.

### Steps:
1.  Go to your GitHub profile: `https://github.com/ondrej-mikulas-storyous?tab=overview`
2.  Filter by the specific year/month.
3.  Click "Show more activity" if needed.
4.  Note down the counts for each month.
5.  *Tip:* Don't forget to include activity from all relevant organizations (e.g., `Saltpay`).

*(See the `fetch_github_stats.py` script provided in this folder for an automated way to get these numbers if you have the GitHub CLI installed).*

## Phase 3: Competency Matrix (Self-Assessment)

**Goal:** Evaluate yourself against the Tech Competencies Matrix.

### Instructions:
1.  Open your company's **Tech Competencies Matrix**.
2.  For your current level (and the one above/below):
    *   **Green Circle:** Consistently demonstrating this skill (multiple evidences).
    *   **Yellow Circle:** Sometimes demonstrating / few evidences.
    *   **Red Circle:** No evidence yet.
3.  **Comment:** Add specific examples for the "Green" and "Yellow" items.
    *   *Example:* "Refactored the payment module (link to PR) demonstrating 'Clean Code' competency."

## Phase 4: Evidence Gathering (Memory Refresh)

**Goal:** Fill in the gaps if you don't remember specific tasks.

### Search Strategies:
1.  **Jira Filters:**
    Use this JQL to find your completed work:
    ```jql
    project = STOR AND (status changed to Done during ("2025/01/01", "2025/06/30")) AND assignee = currentUser() order by timespent DESC, created DESC
    ```
    *Replace the dates with your review period.*

2.  **Confluence Search:**
    *   Search for pages created by you.
    *   Search for pages where you are mentioned.

3.  **Slack:**
    *   Search for "from:me" in key project channels to see what you were discussing/shipping.

## Phase 5: Assembly

Use the `CONFLUENCE_TEMPLATE.md` file to structure your final page. Copy the content you generated in Phases 1-3 into the template.

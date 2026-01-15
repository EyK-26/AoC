import subprocess
import json
import calendar
from datetime import datetime, timedelta

def run_gh_query(username, start_date, end_date):
    # GraphQL query to get contribution stats
    # Note: This aggregates counts across all organizations the token has access to.
    query = """
    query($userName:String!, $from:DateTime!, $to:DateTime!) {
      user(login: $userName) {
        contributionsCollection(from: $from, to: $to) {
          totalCommitContributions
          totalPullRequestContributions
          totalPullRequestReviewContributions
        }
      }
    }
    """
    
    # Format dates to ISO 8601
    start_iso = start_date.strftime("%Y-%m-%dT%H:%M:%SZ")
    end_iso = end_date.strftime("%Y-%m-%dT%H:%M:%SZ")
    
    # Construct the command
    cmd = [
        "gh", "api", "graphql",
        "-f", f"query={query}",
        "-f", f"userName={username}",
        "-f", f"from={start_iso}",
        "-f", f"to={end_iso}"
    ]
    
    try:
        result = subprocess.run(cmd, capture_output=True, text=True, check=True)
        data = json.loads(result.stdout)
        return data["data"]["user"]["contributionsCollection"]
    except subprocess.CalledProcessError as e:
        print(f"Error running gh command for {start_date.strftime('%B')}: {e.stderr.strip()}")
        if "Resource not accessible by integration" in e.stderr:
            print("Tip: Your token might not have permissions to read user stats. Try 'gh auth refresh -s read:user'.")
        return None
    except Exception as e:
        print(f"Error: {e}")
        return None

def main():
    print("--- GitHub Stats Fetcher ---")
    print("This script uses the GitHub CLI ('gh') to fetch your contribution stats.")
    print("Ensure you are logged in with 'gh auth login'.")
    print("Note: To include organization (e.g., Saltpay) stats, ensure your token has SSO authorized.")
    
    username = input("Enter GitHub username (default: @me): ").strip() or "@me"
    if username == "@me":
        # Resolve @me to actual username
        try:
            res = subprocess.run(["gh", "api", "user", "--jq", ".login"], capture_output=True, text=True, check=True)
            username = res.stdout.strip()
            print(f"Detected username: {username}")
        except:
            print("Could not automatically detect username (token might be restricted).")
            username = input("Please enter your GitHub username manually: ").strip()
            if not username:
                print("Username required.")
                return

    year_str = input("Enter Year (e.g., 2025): ").strip()
    if not year_str:
        print("Year is required.")
        return
    year = int(year_str)

    print(f"\nFetching stats for {username} in {year}...\n")
    print(f"{'Month':<15} | {'Commits':<10} | {'PRs':<10} | {'Reviews':<10}")
    print("-" * 55)

    for month in range(1, 13):
        # Calculate start and end of the month
        last_day = calendar.monthrange(year, month)[1]
        start_date = datetime(year, month, 1, 0, 0, 0)
        end_date = datetime(year, month, last_day, 23, 59, 59)
        
        # Don't fetch for future dates (unless year is in past)
        if start_date > datetime.now():
            break
            
        stats = run_gh_query(username, start_date, end_date)
        
        if stats:
            commits = stats["totalCommitContributions"]
            prs = stats["totalPullRequestContributions"]
            reviews = stats["totalPullRequestReviewContributions"]
            
            month_name = calendar.month_name[month]
            print(f"{month_name:<15} | {commits:<10} | {prs:<10} | {reviews:<10}")

if __name__ == "__main__":
    main()

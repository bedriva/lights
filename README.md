# lights
lights is a really light weight CMS with actual WYSIWYG and file store. The lights core should follow the following principles:

- What you see is really what you get. Content that you edit MUST look the same after you've saved it. No unpleasant surprises.
- All data must be stored in the file system. No database involved.
- It must be fast.

These principles only applies to the lights core though, so plugins and custom development doesn't have to work like this.

## Why?
Today's popular CMS systems have done a great job during the last 15 years. Publishing and editing websites are easier than ever before, but the users and developers are still not happy. The main complaints from authors concerns the content editing process, and many developers generally don't like the software design principles of existing systems.

lights goal for the user is to help the content author to edit the site more easily. With true WYSIWYG editing, authors doesn't have to waste time in the edit/preview cycle.

The goal for the developer is to be able to develop the functions that the client need instead of focusing on learning a huge CMS, which still needs a lot of plugins to be functional. When using a file store instead of a database we can version control and push content updates without messing with different versions of the database.

## How do I install?
1. Clone the project `git clone https://github.com/bedriva/lights.git`
2. Modify the user credentials in `lights-data/users/admin.json`
3. Browse the site through your favorite browser

## Content structure
All site data is stored in files - not in a database.

## What's on the roadmap?
- [x] User login
- [x] WYSIWYG editing
- [x] Shared widgets
- [ ] Version handling
- [ ] News/blog
- [ ] Select on which pages widgets should appear
- [ ] More attractive base theme
- [ ] Modular inline editing tool
- [ ] Passwordless login

# Currokit
About currokit: [pending redaction]

---

## Project structure
This reflects a minimized version of the file structure where only
the relevant directories are shown.
```
currokit
├ app/
│   ├ Enums/                Enum definitions
│   ├ Http/
│   │   └ Controllers/      Main business logic
│   ├ Models/               Entity models  
│   └ Observers/            Triggers on entity updates
├ database/
│   └ migrations/           Database migrations for models
├ resources/
│   └ js/                   -> React app directory <-
├ tests/                    Testing suite
└ makefile                  Command line shortcuts

currokit/resources/js
├ components/
├ layouts/
└ pages/
```

## Objectives

## Issues
- [ ]   1: [DESIGN] Logo could use a bit of thinning out

---

## History
### 0.2.0-alpha426: Implemented main layout
- Imported menus into sidebar and top bar
- Updated usage of colors
- Translated default setting pages
- Modified UI to match expectation
### 0.1.0-alpha421: Established baseline
- Database schemas and migrations have been imported
- Baseline for UI styles has been imported
- Unrequired inertia boilerplate is removed 

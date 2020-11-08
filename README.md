# CIJ Open Lab Website

Interface to the CIJ Open Lab Database.

The Centre for Investigative Journalism (CIJ) is a think-tank, alternative university and an experimental laboratory set up to train a new generation of reporters in the tools of investigative, in-depth, and long-form journalism across all media. Registered as a charity, we robustly defend investigative journalists and those who work with them.







# Custom kirbytags

&nbsp;

## (bettervideo: &hellip;)

> Enhancement ideas
Colored margin for videos
figure{ padding: 4em; background-color: #XXXXXX; }
(bettervideo: … margin: #XXXXXX)

Embeds a video from youtube or vimeo.
Extension of Kirby's (video: &hellip;).

**ATTRIBUTES**

- `bettervideo (string)` - URL of video to embed from youtube or vimeo
- `ratio (string)` - Expressed as a fraction, e.g.: `4/3` or `2000/650`. Default is `16/9`
- `poster (string)` - file name for poster image uploaded in the panel
- `margin (string)` - adds a colored margin to the video using the input string for the color

**EXAMPLES**

Insert a video.
```
(bettervideo: https://www.youtube.com/watch?v=Cpt0BKPSTw0) // youtube

(bettervideo: https://vimeo.com/111607322) // vimeo
```

Control ratio.
```
(bettervideo: https://vimeo.com/111607322 ratio: 4/3)
```

Add caption.
```
(bettervideo: https://vimeo.com/111607322 caption: Voodoo chile voodoo chile)

```

Add poster image. Note that autoplay works only with Vimeo (youtube's iframe api sucks).
```
(bettervideo: https://vimeo.com/111607322 poster: poster.jpg)
```


var layerSliderCustomTransitions = {
    "t2d" : [
 
        {
            "name" : "Sliding from right",
            "rows" : 1,
            "cols" : 1,
            "tile" : {
                "delay" : 0,
                "sequence" : "forward"
            },
            "transition" : {
                "type" : "slide",
                "easing" : "easeInOutQuart",
                "duration" : 1500,
                "direction" : "left"
            }
        },
 
        {
            "name" : "Smooth fading from right",
            "rows" : 1,
            "cols" : 35,
            "tile" : {
                "delay" : 25,
                "sequence" : "reverse"
            },
            "transition" : {
                "type" : "fade",
                "easing" : "linear",
                "duration" : 750,
                "direction" : "left"
            }
        },
 
        {
            "name" : "Sliding random tiles to random directions",
            "rows" : [2,4],
            "cols" : [4,7],
            "tile" : {
                "delay" : 50,
                "sequence" : "random"
            },
            "transition" : {
                "type" : "slide",
                "easing" : "easeOutQuart",
                "duration" : 500,
                "direction" : "random"
            }
        },
 
        {
            "name" : "Fading tiles col-forward",
            "rows" : [2,4],
            "cols" : [4,7],
            "tile" : {
                "delay" : 30,
                "sequence" : "col-forward"
            },
            "transition" : {
                "type" : "fade",
                "easing" : "easeOutQuart",
                "duration" : 1000,
                "direction" : "left"
            }
        },
 
        {
            "name" : "Fading and sliding columns to bottom (forward)",
            "rows" : 1,
            "cols" : [12,16],
            "tile" : {
                "delay" : 75,
                "sequence" : "forward"
            },
            "transition" : {
                "type" : "mixed",
                "easing" : "easeInOutQuart",
                "duration" : 600,
                "direction" : "bottom"
            }
        }
    ],
 
    "t3d" : [
 
        {
            "name" : "Turning cuboid to right (90&#176;)",
            "rows" : 1,
            "cols" : 1,
            "tile" : {
                "delay" : 75,
                "sequence" : "forward"
            },
            "animation" : {
                "transition" : {
                    "rotateY" : 90
                },
                "easing" : "easeInOutQuart",
                "duration" : 1500,
                "direction" : "horizontal"
            }
        },
 
        {
            "name" : "Vertical spinning rows random (540&#176;)",
            "rows" : [3,7],
            "cols" : 1,
            "tile" : {
                "delay" : 150,
                "sequence" : "random"
            },
            "animation" : {
                "transition" : {
                    "rotateX" : -540
                },
                "easing" : "easeInOutBack",
                "duration" : 2000,
                "direction" : "vertical"
            }
        },
 
        {
            "name" : "Scaling and spinning columns to left (180&#176;)",
            "rows" : 1,
            "cols" : [7,11],
            "tile" : {
                "delay" : 75,
                "sequence" : "reverse"
            },
            "before" : {
                "enabledd" : true,
                "transition" : {
                    "scale3d" : ".85"
                },
                "duration" : 600,
                "easing" : "easeOutBack"
            },
            "animation" : {
                "transition" : {
                    "rotateY" : -180
                },
                "easing" : "easeInOutBack",
                "duration" : 1000,
                "direction" : "horizontal"
            },
            "after" : {
                "enabled" : true,
                "transition" : {
                    "delay" : 200
                },
                "easing" : "easeOutBack",
                "duration" : 600
            }
        },
 
        {
            "name" : "Scaling and horizontal spinning cuboids random (180&#176;, large depth)",
            "rows" : [2,4],
            "cols" : [4,7],
            "tile" : {
                "delay" : 75,
                "sequence" : "random",
                "depth" : "large"
            },
            "before" : {
                "enabled" : true,
                "transition" : {
                    "scale3d" : ".65"
                },
                "duration" : 700,
                "easing" : "easeInOutQuint"
            },
            "animation" : {
                "transition" : {
                    "rotateY" : 180
                },
                "easing" : "easeInOutBack",
                "duration" : 700,
                "direction" : "horizontal"
            },
            "after" : {
                "enabled" : true,
                "duration" : 700,
                "easing" : "easeInOutBack"
            }
        },
 
        {
            "name" : "Scaling and spinning rows to right (180&#176;)",
            "rows" : [5,9],
            "cols" : 1,
            "tile" : {
                "delay" : 75,
                "sequence" : "forward"
            },
            "before" : {
                "enabled" : true,
                "transition" : {
                    "scale3d" : ".85"
                },
                "duration" : 600,
                "easing" : "easeOutBack"
            },
            "animation" : {
                "transition" : {
                    "rotateY" : 180
                },
                "easing" : "easeInOutBack",
                "duration" : 1000,
                "direction" : "horizontal"
            },
            "after" : {
                "enabled" : true,
                "transition" : {
                    "delay" : 200
                },
                "easing" : "easeOutBack",
                "duration" : 600
            }
        }
    ]
};